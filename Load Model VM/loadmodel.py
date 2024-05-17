import json
import pickle
import paho.mqtt.client as mqtt
from sklearn.svm import SVC
import datetime
import pytz 
import mysql.connector
from ntplib import NTPClient

def get_ntp_time():
    c = NTPClient()
    response = c.request('pool.ntp.org')
    return datetime.datetime.fromtimestamp(response.tx_time, tz_GMT7)


with open('svm_model.pkl', 'rb') as file:
    clf = pickle.load(file)

# MQTT Settings
# MQTT_BROKER = "40.81.29.43"
# MQTT_PORT = 1883

MQTT_BROKER = "broker.sinaungoding.com"
MQTT_PORT = 1883
MQTT_USERNAME = "uwais"
MQTT_PASSWORD = "uw415_4Lqarn1"

# MQTT_TOPIC = "E8:DB:84:86:3B:DA/rssi_data" 
# MQTT_TOPIC_PUBLISH = "E8:DB:84:86:3B:DA/hasilprediksi" 
# MQTT_TOPIC_LOG = "E8:DB:84:86:3B:DA/datalog" 

mac_addresses = []

tz_GMT7 = pytz.timezone('Asia/Jakarta')

conn = mysql.connector.connect(
    host="localhost",
    user="alaudin",
    password="123",
    database="ips"
)

def get_mac_addresses_from_database():
    global mac_addresses
    cursor = conn.cursor()
    cursor.execute("SELECT mac FROM perangkats")
    mac_addresses = [mac[0] for mac in cursor.fetchall()]

def predict_room(rssi_data):
    prediction = clf.predict([rssi_data])

    return prediction[0]  # Mengambil hasil prediksi dari array hasil

def on_connect(self, client, userdata, flags, rc):
    print(f"Connected pred with result code {rc}")

    # Subscribe to MQTT topic
    get_mac_addresses_from_database()
    for mac_address in mac_addresses:
        self.subscribe(f"{mac_address}/rssi_data")
        self.subscribe(f"{mac_address}/datalog")

    # self.subscribe(MQTT_TOPIC)
    # self.subscribe(MQTT_TOPIC_LOG)

def on_message(client, userdata, msg):

    # Extract MAC address from topic
    mac_address_prefix = msg.topic.split('/')[0]

    # Process the message based on its topic
    if msg.topic.endswith("/rssi_data"):
        decoded_msg = msg.payload.decode()
        json_data = json.loads(decoded_msg)
        rssi_data = json_data['data']
        waktu_esp_kirim = json_data['wek']
        mac = json_data['mac']

        # if rssi_data == [0]*16:
        #     waktu_setelah_prediksi = ""
        #     prediction = "diluar jangkauan"
        # else:
        #     prediction = predict_room(rssi_data)
        #     waktu_setelah_prediksi = datetime.datetime.now(pytz.timezone('Asia/Jakarta')).strftime('%H:%M:%S')
        
        prediction = predict_room(rssi_data)
        waktu_setelah_prediksi = get_ntp_time().strftime('%H:%M:%S')

        result_message = {"mac": mac,
                          "data": rssi_data,
                          "wek": waktu_esp_kirim,
                          "wsk": waktu_setelah_prediksi,
                          "predicted_room": prediction}
        
        client.publish(f"{mac_address_prefix}/hasilprediksi", json.dumps(result_message))

        print("mac:", mac," | Prediction:", prediction, "| wek:", waktu_esp_kirim, "| wsk:", waktu_setelah_prediksi)
    
    elif msg.topic.endswith("/datalog"):
        cursor = conn.cursor()

        decoded_msg = msg.payload.decode()
        json_data = json.loads(decoded_msg)

        # Extract data from MQTT message
        mac = json_data['mac']
        rssi_data = json_data['data']
        waktu_esp_kirim = json_data['wek']
        waktu_server_kirim = json_data['wsk']
        predicted_room = json_data['predicted_room']
        waktu_esp_terima = json_data['wet']

        # Save data to MySQL database
        # sql = "INSERT INTO logdata (mac, data, wek, wsk, predicted_room, wet) VALUES (%s, %s, %s, %s, %s, %s)"
        # val = (mac, json.dumps(rssi_data), waktu_esp_kirim, waktu_server_kirim, predicted_room, waktu_esp_terima)
        # cursor.execute(sql, val)
        # conn.commit()

        # Print message if data is successfully saved
        # print("Data ",mac," berhasil disimpan ke dalam database MySQL")
        



try:
    # Set up MQTT client
    client = mqtt.Client(mqtt.CallbackAPIVersion.VERSION2)

    # Set callback functions
    client.on_connect = on_connect
    client.on_message = on_message


    # Connect to MQTT broker    
    client.username_pw_set(MQTT_USERNAME, password=MQTT_PASSWORD)
    client.connect(MQTT_BROKER, MQTT_PORT, 60)

    # Start the MQTT loop to listen for incoming messages
    client.loop_forever()


except KeyboardInterrupt:
    print("Keyboard Interrupt detected. Disconnecting...")

    result_message = {"mac": "",
                        "data": "",
                        "wek": "",
                        "wsk": "",
                        "predicted_room": "Classifier terputus"}
    
    for mac_address in mac_addresses:
        client.publish(f"{mac_address}/hasilprediksi", json.dumps(result_message))
   
    conn.close()
    client.disconnect()