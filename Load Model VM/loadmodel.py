import json
import pickle
import paho.mqtt.client as mqtt
from sklearn.svm import SVC
from datetime import datetime
import pytz 
import mysql.connector
import ntplib

def get_ntp_time():
    client = ntplib.NTPClient()
    response = client.request('time.google.com')
    return int(response.tx_time + 25200)


with open('svm_model.pkl', 'rb') as file:
    clf = pickle.load(file)

MQTT_BROKER = "broker.sinaungoding.com"
MQTT_PORT = 1883
MQTT_USERNAME = "uwais"
MQTT_PASSWORD = "uw415_4Lqarn1"

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

    return prediction[0]

def on_connect(self, client, userdata, flags, rc):
    print(f"Connected pred with result code {rc}")

    # Subscribe to MQTT topic
    get_mac_addresses_from_database()
    for mac_address in mac_addresses:
        self.subscribe(f"{mac_address}/rssi_data")
        self.subscribe(f"{mac_address}/datalog")


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

        # if rssi_data == [-100]*16:
        #     prediction = "diluar jangkauan"
        #     waktu_setelah_prediksi = ""
        # else:
        #     prediction = predict_room(rssi_data)
        #     waktu_setelah_prediksi = get_ntp_time().strftime('%H:%M:%S')

        
        prediction = predict_room(rssi_data)
        waktu_setelah_prediksi = get_ntp_time()

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

        now = datetime.now(tz_GMT7)

        # Extract data from MQTT message
        mac = json_data['mac']
        rssi_data = json_data['data']
        waktu_esp_kirim = json_data['wek']
        waktu_server_kirim = json_data['wsk']
        predicted_room = json_data['predicted_room']
        waktu_esp_terima = json_data['wet']
        waktu_data_simpan = now.strftime("%d/%m/%Y - %H:%M:%S")

        # Save data to MySQL database
        sql = "INSERT INTO logdata (mac, data, wek, wsk, predicted_room, wet, waktu_simpan) VALUES (%s, %s, %s, %s, %s, %s, %s)"
        val = (mac, json.dumps(rssi_data), waktu_esp_kirim, waktu_server_kirim, predicted_room, waktu_esp_terima, waktu_data_simpan)
        cursor.execute(sql, val)
        conn.commit()

        # Print message if data is successfully saved
        print("Data ",mac," berhasil disimpan ke dalam database MySQL")
        



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