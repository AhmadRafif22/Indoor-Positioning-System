#include <Arduino.h>
#include <ESP8266WiFi.h>
#include <PubSubClient.h>
#include <ArduinoJson.h>
#include <SPI.h>
#include <Wire.h>
#include <Adafruit_GFX.h>
#include <Adafruit_SSD1306.h>
#include <NTPClient.h>
#include <WiFiUdp.h>

#define SCREEN_WIDTH 128
#define SCREEN_HEIGHT 64

Adafruit_SSD1306 display(SCREEN_WIDTH, SCREEN_HEIGHT, &Wire, -1);

// mqtt
// const char *mqtt_server = "localhost";
// const char *mqtt_server = "broker.hivemq.com";
// const char *mqtt_server = "test.mosquitto.org";
// const char *mqtt_server = "40.81.29.43";

const char *mqtt_server = "broker.sinaungoding.com";
const int mqttPort = 1883;
const char *mqtt_username = "uwais";
const char *mqtt_password = "uw415_4Lqarn1";

const bool debug = false;
// const bool debug = true;

WiFiClient espClient;
PubSubClient client(espClient);

WiFiUDP ntpUDP;
NTPClient timeClient(ntpUDP, "pool.ntp.org", 25200);

String macAddr;

String globalPrediksi;

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

// const char *jokopuchi = "00:AD:24:67:02:4C";

void callback(char *topic, byte *payload, unsigned int length)
{
  timeClient.update();

  String waktuEspTerima = timeClient.getFormattedTime();

  Serial.print("Prediksi : ");

  String message;
  for (int i = 0; i < length; i++)
  {
    message += (char)payload[i];
  }
  Serial.println(message);

  if (message == "")
  {
    globalPrediksi = "Menunggu . .";
  }

  DynamicJsonDocument doc(1024);
  deserializeJson(doc, payload, length);

  const char *mac = doc["mac"];
  JsonArray rssiData = doc["data"];
  const char *waktuEspKirim = doc["wek"];
  const char *waktuSetelahPrediksi = doc["wsk"];
  const char *predictedRoom = doc["predicted_room"];

  display.setTextSize(1);
  display.setTextColor(WHITE);
  display.setCursor(0, 0);

  if (debug == true)
  {
    display.clearDisplay();
    display.print("Mac:");
    display.println(mac);
    display.print("RSSI : [");
    for (int i = 0; i < rssiData.size(); i++)
    {
      display.print(rssiData[i].as<int>());
      display.print(",");
    }
    display.print("]");
    display.print("\nEsp Kirim : ");
    display.println(waktuEspKirim);
    display.print("Prediksi : ");
    display.println(waktuSetelahPrediksi);
    display.print("Esp Terima : ");
    display.println(waktuEspTerima);
    display.print("Lokasi Anda : ");
    display.println(predictedRoom);
    display.display();
  }
  else
  {
    globalPrediksi = predictedRoom;
  }

  // Menampilkan nama ruangan pada OLED

  StaticJsonDocument<1024> publishDoc;
  publishDoc["mac"] = mac;
  publishDoc["data"] = rssiData;
  publishDoc["wek"] = waktuEspKirim;
  publishDoc["wsk"] = waktuSetelahPrediksi;
  publishDoc["predicted_room"] = predictedRoom;
  publishDoc["wet"] = waktuEspTerima;

  char publishBuffer[1024];
  serializeJson(publishDoc, publishBuffer);

  Serial.print("logdata : ");
  Serial.println(publishBuffer);
  Serial.println("======================");

  String topic_datalog = macAddr + "/datalog";
  client.publish(topic_datalog.c_str(), publishBuffer);
}

void setup()
{
  Serial.begin(115200);

  while (!Serial)
  {
    delay(10);
  }
  if (!display.begin(SSD1306_SWITCHCAPVCC, 0x3C))
  { // Address 0x3D for 128x64
    Serial.println(F("SSD1306 allocation failed"));
    for (;;)
      ;
  }

  // Clear the buffer and reset the display
  display.clearDisplay();
  display.setTextSize(1);
  display.setTextColor(WHITE);
  display.setCursor(0, 0);
  display.println("\n\nMemulai Indoor Positioning System... ");
  display.display();

  // WiFi.begin("JTI-POLINEMA", "jtifast!");
  // WiFi.begin("Joko Puchi", "yondatau");
  WiFi.begin("Araspot", "yondatau");
  // WiFi.begin("White House", "abahganteng");
  while (WiFi.status() != WL_CONNECTED)
  {
    delay(1000);
    Serial.println("Connecting to WiFi...");
  }

  macAddr = WiFi.macAddress();
  macAddr = macAddr.c_str();

  client.setServer(mqtt_server, mqttPort);

  timeClient.begin();

  timeClient.update();

  client.setCallback(callback);

  globalPrediksi = "Menunggu . . .";
}

void reconnect()
{
  while (!client.connected())
  {
    globalPrediksi = "Menunggu . . .";

    Serial.print("Attempting MQTT connection...");
    if (client.connect(macAddr.c_str(), mqtt_username, mqtt_password))
    {
      Serial.println("connected");
      String topicHasilPrediksi = macAddr + "/hasilprediksi";
      client.subscribe(topicHasilPrediksi.c_str());
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

  if (!client.connected())
  {
    reconnect();
  }

  static unsigned long previousMillis = 0;
  static unsigned long previousMillisClock = 0;
  const long interval = 15000;     // setiap 15 detik
  const long intervalClock = 1000; // setiap 1 detik

  unsigned long currentMillis = millis();

  if (currentMillis - previousMillisClock >= intervalClock)
  {
    // Simpan waktu sekarang
    previousMillisClock = currentMillis;

    if (!debug)
    {
      display.clearDisplay();

      timeClient.update();

      // Mengambil waktu saat ini
      // String waktu = timeClient.getFormattedTime();
      time_t epochTime = timeClient.getEpochTime();
      struct tm *timeinfo;
      timeinfo = localtime(&epochTime);

      display.setTextSize(1);
      display.setTextColor(WHITE);
      display.setCursor(0, 0);

      display.print(timeinfo->tm_mday);
      display.print("/");
      display.print(timeinfo->tm_mon + 1);
      display.print("/");
      display.print(timeinfo->tm_year + 1900);
      display.print(" ");

      char hourBuffer[3];
      sprintf(hourBuffer, "%02d", timeinfo->tm_hour);
      display.print(hourBuffer);

      display.print(":");

      char minBuffer[3];
      sprintf(minBuffer, "%02d", timeinfo->tm_min);
      display.print(minBuffer);

      display.print(":");

      char secBuffer[3];
      sprintf(secBuffer, "%02d", timeinfo->tm_sec);
      display.print(secBuffer);
      display.println("\n");

      display.println(macAddr);

      display.println("\n\nLokasi Anda : ");
      display.println("\n" + globalPrediksi);

      display.display();
    }
  }

  if (currentMillis - previousMillis >= interval)
  {
    // Simpan waktu sekarang
    previousMillis = currentMillis;

    // if (!client.connected())
    // {
    //   reconnect();
    // }

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

    timeClient.update();

    // Mengambil waktu saat ini
    String waktu = timeClient.getFormattedTime();

    char message[255];
    snprintf(message, sizeof(message),
             "{\"mac\": \"%s\",\"data\": [%d,%d,%d,%d,%d,%d,%d,%d,%d,%d,%d,%d,%d,%d,%d,%d],\"wek\": \"%s\"}",
             macAddr.c_str(), RSSIdosen1, RSSIdosen2, RSSIdosen3, RSSIdosen4, RSSIjurusan, RSSIdosen5, RSSIadmin, RSSIdosen6, RSSIbaca, RSSIarsip, RSSIlsi1, RSSIlpy2, RSSIlsi2, RSSIlpy3, RSSIlsi3, RSSIekosistem, waktu.c_str());

    String topic_rssi_data = macAddr + "/rssi_data";
    client.publish(topic_rssi_data.c_str(), message);

    Serial.println("\n======================");
    Serial.print("RSSI : ");
    Serial.println(message);
  }

  client.loop();
}
