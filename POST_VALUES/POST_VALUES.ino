#include <WiFi101.h>
#include <ArduinoHttpClient.h>
#include <DHT.h>
#include <TimeLib.h>

#define DHTPIN 6           // Pin Digital onde está ligado o sensor
#define DHTTYPE DHT11      // Tipo de sensor DHT
#define LEDARDUINO 5
#define LEDLUZ 4



DHT dht(DHTPIN, DHTTYPE);  // Instanciar e declarar a class DHT

char SSID[] = "labs_lca";
char PASS_WIFI[] = "robot1cA!ESTG";
// - mudar para o ip do João
char URL[] = "10.79.12.60";
int PORTO = 80;
WiFiClient clienteWifi;
HttpClient clienteHTTP = HttpClient(clienteWifi, URL, PORTO);

void setup() {
  Serial.begin(115200);

  WiFi.begin(SSID, PASS_WIFI);
  Serial.println("A ligar ao wifi");

  while (WiFi.status() != WL_CONNECTED) {
    Serial.print(".");
    delay(500);
  }

  Serial.println("Connected");

  dht.begin();
}

void loop() {

  String datahora = String(year()) + "-" + month() + "-" + day() + " " + hour() + ":" + minute() + ":" + second();
  // Ler valores do sensor
  float h = dht.readHumidity();
  float t = dht.readTemperature();
  
  //VAI BUSCAR A TEMPERATURA NA API
  clienteHTTP.get("/EstufaInteligente/api/api.php?nome=temperatura");
  if (clienteHTTP.responseStatusCode() == 200) {
    float valortemp = clienteHTTP.responseBody().toFloat();
  
    // Verifica se o valor da temperatura é igual ao que esta na API
    if(valortemp != t)
    {
      Serial.print("Temperatura Diferente");
      post2API("temperatura", String(t), datahora);
    }
    else{
      Serial.print("Temperatura IGUAL");
    }
    
  
  } else {
    Serial.print("Ocorreu erro a fazer o pedido GET: ");
    Serial.println(clienteHTTP.responseStatusCode());
  }

  //VAI BUSCAR A HUMIDADE NA API
  clienteHTTP.get("/EstufaInteligente/api/api.php?nome=humidade");
  if (clienteHTTP.responseStatusCode() == 200) {
    float valorhum = clienteHTTP.responseBody().toFloat();

    // Verifica se o valor da humidade é igual ao que esta na API
    if(valorhum != h)
    {
      Serial.print("Humidade Diferente");
      post2API("humidade", String(h), datahora);
    }
    else
    {
      Serial.print("Temperatura Diferente");
    }
    

  } else {
    Serial.print("Ocorreu erro a fazer o pedido GET: ");
    Serial.println(clienteHTTP.responseStatusCode());
  }


  // VAI BUSCAR A LUZ NA API
  clienteHTTP.get("/EstufaInteligente/api/api.php?nome=luz");
  if (clienteHTTP.responseStatusCode() == 200) {
    int valorluz = int(clienteHTTP.responseBody().toFloat());

    // VAI BUSCAR O VALOR DA LAMPADA
    clienteHTTP.get("/EstufaInteligente/api/api.php?nome=led");
    if (clienteHTTP.responseStatusCode() == 200) {
      int valorled = int(clienteHTTP.responseBody().toFloat());

      // verifica se esta de noite
      if (valorluz == 0) 
      {
        Serial.print("NOITE");
        // se o led estiver desligado -> liga
        if(valorled != 1)
        {
          digitalWrite(LEDLUZ, HIGH);
          post2API("led", "1", datahora);
        }
          
      }
      else 
      {
        Serial.print("DIA");
        // se esta de dia e o led ligado -> desligamos
        if(valorled != 0)
        {
          digitalWrite(LEDLUZ, LOW);
          post2API("led", "0", datahora);
        }
      }

    } else {
      Serial.print("Ocorreu erro a fazer o pedido GET: ");
      Serial.println(clienteHTTP.responseStatusCode());
    }

    } else {
      Serial.print("Ocorreu erro a fazer o pedido GET: ");
      Serial.println(clienteHTTP.responseStatusCode());
    }

  

  // VAI BUSCAR O LED ARDUINO
  clienteHTTP.get("/EstufaInteligente/api/api.php?nome=LedArduino");
  if (clienteHTTP.responseStatusCode() == 200) {
    int valorledArduino = int(clienteHTTP.responseBody().toFloat());
    if (valorledArduino == 1){
      Serial.print("LIGADO");
      digitalWrite(LEDARDUINO,HIGH);
    }
    else
    {
      Serial.print("DESLIGADO");
      digitalWrite(LEDARDUINO,LOW);
    }
  } else {
    Serial.print("Ocorreu erro a fazer o pedido GET: ");
    Serial.println(clienteHTTP.responseStatusCode());
  }


  
  delay(2000);
}



void post2API(String nome, String valor, String hora) {
  clienteHTTP.post("/EstufaInteligente/api/api.php", "application/x-www-form-urlencoded", "nome=" + nome + "&valor=" + valor + "&hora=" + hora);

  int status = clienteHTTP.responseStatusCode();
  Serial.print("Status: ");
  Serial.println(status);
  if (status == 200) {
    String response = clienteHTTP.responseBody();
    Serial.println("\tBody: " + response);
  } else {
    Serial.println("\nFalha a obter uma resposta");
  }
}
