#include <Arduino.h>
#include <ESP8266WiFi.h>
#include <LiquidCrystal_I2C.h>
#include <PubSubClient.h>
#include <ArduinoJson.h>

// mqtt
// const char *mqtt_server = "localhost";
const char *mqtt_server = "broker.hivemq.com";
// const char *mqtt_server = "test.mosquitto.org";
const int mqttPort = 1883;

WiFiClient espClient;
PubSubClient client(espClient);

String macAddr = "";

// list mac address
const char *dosen1 = "B4:FB:E4:F7:67:99";
const char *dosen2 = "B4:FB:E4:F7:68:35";
const char *dosen3 = "B4:FB:E4:F7:68:C0";
const char *dosen4 = "B4:FB:E4:F7:67:69";
const char *jurusan = "B4:FB:E4:F7:6A:AE";
const char *dosen5 = "B4:FB:E4:F7:68:74";
const char *admin = "B4:FB:E4:F7:68:C1";
const char *dosen6 = "B4:FB:E4:F7:68:46";
const char *baca = "B4:FB:E4:F7:67:AF";
const char *arsip = "B4:FB:E4:F7:67:B7";
const char *lsi1 = "B4:FB:E4:F7:69:08";
const char *lpy2 = "B4:FB:E4:F7:69:10";
const char *lsi2 = "B4:FB:E4:F7:6A:A0";
const char *lpy3 = "B4:FB:E4:F7:68:1F";
const char *lsi3 = "B4:FB:E4:F7:67:B9";
const char *ekosistem = "B4:FB:E4:F7:68:30";

const char *jokopuchi = "00:AD:24:67:02:4C";

void setup()
{
  Serial.begin(115200);

  // WiFi.begin("JTI-POLINEMA", "jtifast!");
  // WiFi.begin("jokopuchi", "yondatau");
  WiFi.begin("Araspot", "yondatau");
  while (WiFi.status() != WL_CONNECTED)
  {
    delay(1000);
    Serial.println("Connecting to WiFi...");
  }
  macAddr = WiFi.macAddress();
  client.setServer(mqtt_server, mqttPort);
}

void reconnect()
{
  while (!client.connected())
  {
    Serial.print("Attempting MQTT connection...");
    if (client.connect(macAddr.c_str()))
    {
      Serial.println("connected");
    }
    else
    {
      Serial.print("failed, rc=");
      Serial.print(client.state());
      Serial.println(" try again in 5 seconds");
      delay(5000);
    }
  }
}

int getRSSI(const char *mac)
{
  int RSSI = 0;

  int numberOfNetworks = WiFi.scanNetworks();

  if (numberOfNetworks == 0)
  {
    Serial.println("No networks found");
  }
  else
  {
    for (int i = 0; i < numberOfNetworks; ++i)
    {

      if (WiFi.BSSIDstr(i) == mac)
      {
        RSSI = WiFi.RSSI(i);
      }
    }
  }

  return RSSI;
}

void loop()
{
  static unsigned long previousMillis = 0;
  const long interval = 15000;

  unsigned long currentMillis = millis();

  if (currentMillis - previousMillis >= interval)
  {
    // Simpan waktu sekarang
    previousMillis = currentMillis;

    if (!client.connected())
    {
      reconnect();
    }

    int RSSIdosen1 = 0;
    int RSSIdosen2 = 0;
    int RSSIdosen3 = 0;
    int RSSIdosen4 = 0;
    int RSSIjurusan = 0;
    int RSSIdosen5 = 0;
    int RSSIadmin = 0;
    int RSSIdosen6 = 0;
    int RSSIbaca = 0;
    int RSSIarsip = 0;
    int RSSIlsi1 = 0;
    int RSSIlpy2 = 0;
    int RSSIlsi2 = 0;
    int RSSIlpy3 = 0;
    int RSSIlsi3 = 0;
    int RSSIekosistem = 0;

    // get RSSI
    int RSSI = 0;

    int numberOfNetworks = WiFi.scanNetworks();

    if (numberOfNetworks == 0)
    {
      Serial.println("No networks found");
    }
    else
    {

      for (int i = 0; i < numberOfNetworks; ++i)
      {

        if (WiFi.BSSIDstr(i) == dosen1)
        {
          RSSIdosen1 = WiFi.RSSI(i);
        }
        else if (WiFi.BSSIDstr(i) == dosen2)
        {
          RSSIdosen2 = WiFi.RSSI(i);
        }
        else if (WiFi.BSSIDstr(i) == dosen3)
        {
          RSSIdosen3 = WiFi.RSSI(i);
        }
        else if (WiFi.BSSIDstr(i) == dosen4)
        {
          RSSIdosen4 = WiFi.RSSI(i);
        }
        else if (WiFi.BSSIDstr(i) == jurusan)
        {
          RSSIjurusan = WiFi.RSSI(i);
        }
        else if (WiFi.BSSIDstr(i) == dosen5)
        {
          RSSIdosen5 = WiFi.RSSI(i);
        }
        else if (WiFi.BSSIDstr(i) == admin)
        {
          RSSIadmin = WiFi.RSSI(i);
        }
        else if (WiFi.BSSIDstr(i) == dosen6)
        {
          RSSIdosen6 = WiFi.RSSI(i);
        }
        else if (WiFi.BSSIDstr(i) == baca)
        {
          RSSIbaca = WiFi.RSSI(i);
        }
        else if (WiFi.BSSIDstr(i) == arsip)
        {
          RSSIarsip = WiFi.RSSI(i);
        }
        else if (WiFi.BSSIDstr(i) == lsi1)
        {
          RSSIlsi1 = WiFi.RSSI(i);
        }
        else if (WiFi.BSSIDstr(i) == lpy2)
        {
          RSSIlpy2 = WiFi.RSSI(i);
        }
        else if (WiFi.BSSIDstr(i) == lsi2)
        {
          RSSIlsi2 = WiFi.RSSI(i);
        }
        else if (WiFi.BSSIDstr(i) == lpy3)
        {
          RSSIlpy3 = WiFi.RSSI(i);
        }
        else if (WiFi.BSSIDstr(i) == lsi3)
        {
          RSSIlsi3 = WiFi.RSSI(i);
        }
        else if (WiFi.BSSIDstr(i) == ekosistem)
        {
          RSSIekosistem = WiFi.RSSI(i);
        }
      }
    }

    String ruang = "kelas";

    char message[255];
    snprintf(message, sizeof(message),
             "{\"dosen1\": %d, \"dosen2\": %d, \"dosen3\": %d, \"dosen4\": %d, \"jurusan\": %d, \"dosen5\": %d, \"admin\": %d, \"dosen6\": %d, \"baca\": %d, \"arsip\": %d, \"lsi1\": %d, \"lpy2\": %d, \"lsi2\": %d, \"lpy3\": %d, \"lsi3\": %d, \"ekosistem\": %d, \"ruang\": \"%s\"}",
             RSSIdosen1, RSSIdosen2, RSSIdosen3, RSSIdosen4, RSSIjurusan, RSSIdosen5, RSSIadmin, RSSIdosen6, RSSIbaca, RSSIarsip, RSSIlsi1, RSSIlpy2, RSSIlsi2, RSSIlpy3, RSSIlsi3, RSSIekosistem, ruang);

    client.publish("2041720230/ruang", ruang.c_str());

    client.publish("2041720230/dataRSSI", message);

    client.loop();

    Serial.println(RSSIbaca);
    Serial.println(message);
    Serial.println("======================");
  }
}