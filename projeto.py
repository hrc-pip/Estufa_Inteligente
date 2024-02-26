import requests
import RPi.GPIO as GPIO
from datetime import datetime
import cv2

# IP da máquina do João
IP = "10.79.12.60"



# URL da webcam
webcam_url = "http://10.79.12.55:4747/video"

upload_url = "http://"+ IP +"/EstufaInteligente/api/upload.php"

url = "http://"+ IP +"/EstufaInteligente/api/api.php"


def capturar():
    cap = cv2.VideoCapture(webcam_url)
    ret, frame = cap.read()

    if ret:
        cv2.imwrite(r"C:\UniServerZ\www\projeto\cam\imagem_capturada.jpg", frame)

    cap.release()

    files = {'imagem':open(r"C:\UniServerZ\www\projeto\cam\imagem_capturada.jpg", 'rb')}
    response = requests.post(upload_url, files=files)
    
    if response.status_code == 200:
        print("Uploaded successfully")
    else:
        print("Error uploading file - Status code: " + str(response.status_code) + " - Response text: " + str(response.text))



    
try:
    GPIO.setmode(GPIO.BCM)

    aquecedor = 4
    ventilador = 17
    humidificador = 18
    buzzer = 16
    luz = 12 #switch



    GPIO.setup(aquecedor, GPIO.OUT)
    GPIO.setup(ventilador, GPIO.OUT)
    GPIO.setup(humidificador, GPIO.OUT)
    GPIO.setup(buzzer, GPIO.OUT)
    GPIO.setup(luz, GPIO.IN)

    while True:
        r_temperatura = requests.get(url + "?nome=temperatura")
        r_humidade = requests.get(url + "?nome=humidade") 
        r_buzzer = requests.get(url + "?nome=BuzzerRaspberry")

        r_aquecedor = requests.get(url + "?nome=aquecedor")
        r_ventilador = requests.get(url + "?nome=ventilador")
        r_humidificador = requests.get(url + "?nome=humidificador")
        r_luz = requests.get(url + "?nome=luz")

        

        if int(r_buzzer.text) == 1:
            GPIO.output(buzzer,GPIO.HIGH)
        else:
            GPIO.output(buzzer,GPIO.LOW)


        current_datetime = datetime.now()   
        formatted_datetime = current_datetime.strftime("%Y-%m-%d %H:%M:%S")

        valorLuz = GPIO.input(luz)

        if valorLuz != int(r_luz.text):
            response = requests.post(url, {'nome' : 'luz', 'valor': valorLuz, 'hora' : formatted_datetime})


        capturar()

        if float(r_temperatura.text) > 30:
            GPIO.output(aquecedor,GPIO.LOW)
            GPIO.output(ventilador,GPIO.HIGH)

            if(int(r_aquecedor.text) != 0):
                payload={
                    "nome" : "aquecedor",
                    "valor" : 0,
                    "hora" : formatted_datetime
                }
                response = requests.post(url, data=payload)
                if response.status_code == 200:
                    print("POST request successful")
                else:
                    print("POST request failed")
            
            if(int(r_ventilador.text) != 1):
                payload={
                    "nome" : "ventilador",
                    "valor" : 1,
                    "hora" : formatted_datetime
                }
                response = requests.post(url, data=payload)
                if response.status_code == 200:
                    print("POST request successful")
                else:
                    print("POST request failed")
            
        else:
            if float(r_temperatura.text) < 10:
                GPIO.output(ventilador,GPIO.LOW)
                GPIO.output(aquecedor,GPIO.HIGH)

                if(int(r_ventilador.text) != 0):
                    payload={
                    "nome" : "ventilador",
                    "valor" : 0,
                    "hora" : formatted_datetime
                    }
                    response = requests.post(url, data=payload)
                    if response.status_code == 200:
                        print("POST request successful")
                    else:
                        print("POST request failed")
                
                if(int(r_aquecedor.text) != 1):
                    payload={
                        "nome" : "aquecedor",
                        "valor" : 1,
                        "hora" : formatted_datetime
                    }
                    response = requests.post(url, data=payload)
                    if response.status_code == 200:
                        print("POST request successful")
                    else:
                        print("POST request failed")  

            else:
                GPIO.output(ventilador,GPIO.LOW)
                GPIO.output(aquecedor,GPIO.LOW)

                if(int(r_ventilador.text) != 0):
                    payload={
                    "nome" : "ventilador",
                    "valor" : 0,
                    "hora" : formatted_datetime
                    }
                    response = requests.post(url, data=payload)
                    if response.status_code == 200:
                        print("POST request successful")
                    else:
                        print("POST request failed")
                
                if(int(r_aquecedor.text) != 0):
                    payload={
                        "nome" : "aquecedor",
                        "valor" : 0,
                        "hora" : formatted_datetime
                    }
                    response = requests.post(url, data=payload)
                    if response.status_code == 200:
                        print("POST request successful")
                    else:
                        print("POST request failed")  
            
        

        if float(r_humidade.text) > 50:
            GPIO.output(humidificador,GPIO.LOW)
            
            if(int(r_humidificador.text) != 0):
                payload={
                    "nome" : "humidificador",
                    "valor" : 0,
                    "hora" : formatted_datetime
                }
                response = requests.post(url, data=payload)
                if response.status_code == 200:
                    print("POST request successful")
                else:
                    print("POST request failed")  

        else:
            GPIO.output(humidificador,GPIO.HIGH)

            if(int(r_humidificador.text) != 1):
                payload={
                    "nome" : "humidificador",
                    "valor" : 1,
                    "hora" : formatted_datetime
                }
                response = requests.post(url, data=payload)
                if response.status_code == 200:
                    print("POST request successful")
                else:
                    print("POST request failed")  
except KeyboardInterrupt:
    print("Keyboard interrupt detected. Exiting...")

finally:
    GPIO.cleanup()   