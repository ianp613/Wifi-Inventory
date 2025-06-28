import mysql.connector
from retrieve_data import DATABASE
import telebot
import json


class SHOWDATA:
    def __init__(self):
        self.database= DATABASE()
        self.tables= []
        self.col_tables= []
        self.response= []
        self.container_for_output= []
        self.final_result= ""
        self.intents=""
        self.table_code= {"equip_entry":"a", "ip_add":"b", "ip_net":"c", "isp":"d", "router":"e", "cctv_location":"f","cctv_camera":"g"}

    def runPattern(self):
        with open("intents.json", "r") as file:
            self.intents = json.load(file)

    def equipmentEntry(self, users_input): #need to enhance
        try:
            results= self.database.equipEntry(users_input)
            # print(results)
            for result in results:
                id= result.get("id")
                category= result.get("category")
                descrip= result.get("description")
                model= result.get("model_no")
                bar= result.get("barcode")
                specific= result.get("specifications")
                stats= result.get("status")
                remark= result.get("remarks")
                format_response= ""
                # print(descrip)
                
                if category or descrip or model or bar or specific or stats or remark:
                    if id:
                        text= f"ID: {id}{self.table_code["equip_entry"]}"
                        self.response.append(text)
                    if category:
                        text= f"Category: {category}"
                        self.response.append(text)
                    if descrip:
                        text= f"Description: {descrip}"
                        self.response.append(text)
                    if model:
                        text= f"Model No.: {model}"
                        self.response.append(text)
                    if bar:
                        text= f"Barcode: {bar}"
                        self.response.append(text)
                    if specific:
                        text= f"Specifications: {specific}"
                        self.response.append(text)
                    if stats:
                        text= f"Status: {stats}"
                        self.response.append(text)
                    if remark:
                        text= f"Remarks: {remark}"
                        self.response.append(text)

                    for res in self.response:
                        format_response+= f"{res}\n"
                    
                    # if format_response != "":
                    result= f"---{descrip.upper()}---\n{format_response}\n"
                    self.final_result += result
                    self.container_for_output.append(True)
                    self.response= []
                else:
                    return False
            return True
        except Exception as e:
            # print("No result found!")
            pass
    
    def ipAddress(self, users_input):
        try:
            results= self.database.ipAdd(users_input)
            for result in results:
                id= result.get("id")
                ipadd= result.get("ip")
                net_name= result.get("network_name")
                sub= result.get("subnet")
                host= result.get("hostname")
                site= result.get("site")
                servr= result.get("server")
                stats= result.get("status")
                remark= result.get("remarks")
                webport= result.get("webmgmtpt")
                usrnme= result.get("username")
                paswrd= result.get("password")
                format_response= ""

                if net_name or ipadd or sub or host or site or servr or stats or remark or webport or usrnme or paswrd:
                    if id:
                        text= f"ID: {id}{self.table_code["ip_add"]}"
                        self.response.append(text)
                    if net_name:
                        text= f"Network Name: {net_name}"
                        self.response.append(text)
                    if ipadd:
                        text= f"IP Address: {ipadd}"
                        self.response.append(text)
                    if sub:
                        text= f"Subnet: {sub}"
                        self.response.append(text)
                    if host:
                        text= f"Hostname: {host}"
                        self.response.append(text)
                    if site:
                        text= f"Site: {site}"
                        self.response.append(text)
                    if servr:
                        text= f"Server: {servr}"
                        self.response.append(text)
                    if stats:
                        text= f"Status: {stats}"
                        self.response.append(text)
                    if remark:
                        text= f"Remarks: {remark}"
                        self.response.append(text)
                    if webport:
                        text= f"Web Management Port: {webport}"
                        self.response.append(text)
                    if usrnme:
                        text= f"Username: {usrnme}"
                        self.response.append(text)
                    if paswrd:
                        text= f"Password: {paswrd}"
                        self.response.append(text)

                    for res in self.response:
                        format_response+= f"{res}\n"
                    
                    result= f"---{host.upper()}---\n{format_response}\n"
                    self.final_result += result
                    self.container_for_output.append(True)
                    self.response= []
                    
                else:
                    return False
                    # print("No result found"
            return True
        except Exception as e:
            # print("No result found!")
            pass

    def ipNetwork(self, users_input):
        try:
            results= self.database.ipNet(users_input)
            for result in results:
                id= result.get("id")
                router_name= result.get("router_name")
                name= result.get("name")
                from_= result.get("from")
                to_= result.get("to")
                subnet= result.get("subnet")
                format_response= ""

                if router_name or name or from_ or to_ or subnet:
                    if id:
                        text= f"ID: {id}{self.table_code["ip_net"]}"
                        self.response.append(text)
                    if router_name:
                        text= f"Router Name: {router_name}"
                        self.response.append(text)
                    if name:
                        text= f"Network Name: {name}"
                        self.response.append(text)
                    if from_ or to_:
                        text= f"DHCP Range: {from_} - {to_}"
                        self.response.append(text)
                    if subnet:
                        text= f"Subnet: {subnet}"
                        self.response.append(text)

                    for res in self.response:
                        format_response+= f"{res}\n"

                    result= f"---{name.upper()}---\n{format_response}\n"
                    self.final_result += result
                    self.container_for_output.append(True)
                    self.response= []
                    
                else:
                    return False
            return True
        except Exception as e:
            # print("No result found!")
            pass

    def ISP(self,users_input):
        try:
            results= self.database.isp(users_input)
            for result in results:
                id= result.get("id")
                isp_name= result.get("isp_name")
                name= result.get("name")
                wanip= result.get("wan_ip")
                subnet= result.get("subnet")
                gateway= result.get("gateway")
                dns1= result.get("dns1")
                dns2= result.get("dns2")
                webport= result.get("webmgmtpt")
                format_response= ""
                # print(f"{id} {isp_name} {name} {wanip} {subnet} {gateway} {dns1} {dns2} {webport}")

                if isp_name or name or wanip or subnet or gateway or dns1 or dns2 or webport:
                    # print("True")
                    if id:
                        text= f"ID: {id}{self.table_code["isp"]}"
                        self.response.append(text)
                    if isp_name:
                        text= f"ISP Name: {isp_name}"
                        self.response.append(text)
                    if name:
                        text= f"Name: {name}"
                        self.response.append(text)
                    if wanip:
                        text= f"WAN IP: {wanip}"
                        self.response.append(text)
                    if subnet:
                        text= f"Subnet: {subnet}"
                        self.response.append(text)
                    if gateway:
                        text= f"Gateway: {gateway}"
                        self.response.append(text)
                    if dns1:
                        text= f"DNS 1: {dns1}"
                        self.response.append(text)
                    if dns2:
                        text= f"DNS 2: {dns2}"
                        self.response.append(text)
                    if webport:
                        text= f"Web Management Port: {webport}"
                        self.response.append(text)

                    for res in self.response:
                        format_response+= f"{res}\n"

                    result= f"---{name.upper()}---\n{format_response}\n"
                    self.final_result += result
                    self.container_for_output.append(True)
                    self.response= []
                    # print("have values but error")
                    
                else:
                    return False
            return True
        except Exception as e:
            # print("No result found!")
            # print(e)
            pass

    def routerA(self, users_input):
        try:
            results= self.database.routerB(users_input)
            for result in results:
                id= result.get("id")
                name= result.get("name")
                ip= result.get("ip")
                subnet= result.get("subnet")
                wan1= result.get("wan1")
                wan2= result.get("wan2")
                activ= result.get("active")
                format_response= ""

                if name or ip or wan1 or wan2 or activ:
                    if id:
                        text= f"ID: {id}{self.table_code["router"]}"
                        self.response.append(text)
                    if name:
                        text= f"Name: {name}"
                        self.response.append(text)
                    if ip:
                        text= f"IP: {ip}"
                        self.response.append(text)
                    if subnet:
                        text= f"Subnet: {subnet}"
                        self.response.append(text)

                    if wan1:
                        text= f"WAN 1: {wan1}"
                        self.response.append(text)

                    if wan2:
                        text= f"WAN 2: {wan2}"
                        self.response.append(text)

                    if activ:
                        text= f"Active/Current ISP: {activ}"
                        self.response.append(text)

                    for res in self.response:
                        format_response+= f"{res}\n"

                    result= f"---{name.upper()}---\n{format_response}\n"
                    self.final_result += result
                    self.container_for_output.append(True)
                    self.response= []
                else:
                    return False
            return True

        except Exception as e:
            # print("No result found!")
            pass

    def cctvLocation(self, user_input):
        try:
            results= self.database.cctvLocate(user_input)
            image_path= {}

            for result in results:
                id= result.get("id")
                map_location= result.get("map_location")
                floorplan= result.get("floorplan")
                remarks= result.get("remarks")
                camera_size= result.get("camera_size")
                format_response= ""

                if map_location or floorplan or remarks or camera_size:
                    if id:
                        text= f"ID: {id}{self.table_code["cctv_location"]}"
                        self.response.append(text)
                    if map_location:
                        text= f"Map Location: {map_location}"
                        self.response.append(text)
                    if floorplan:
                        pass
                        # text= f"Floor plan: {floorplan}"
                        # self.response.append(text)
                    if remarks:
                        text= f"Remarks: {remarks}"
                        self.response.append(text)

                    if camera_size:
                        text= f"Camera Size: {camera_size}"
                        self.response.append(text)

                    for res in self.response:
                        format_response+= f"{res}\n"

                    result= f"---{map_location.upper()}---\n{format_response}\n"
                    self.final_result += result
                    self.container_for_output.append(True)
                    image_path[floorplan]= result
                    self.response= []
                else:
                    return False
            return image_path #reference that cctv location or floor plan is being request
        except Exception as e:
            pass
    
    def cctvCamera(self, user_input):
        try:
            results= self.database.cctvCam(user_input)

            for result in results:
                id= result.get("id")
                camera_id= result.get("camera_id")
                camera_type= result.get("camera_type")
                camera_subtype= result.get("camera_subtype")
                camera_ip_address= result.get("camera_ip_address")
                camera_port_no= result.get("camera_port_no")
                camera_username= result.get("camera_username")
                camera_password= result.get("camera_password")
                camera_angle= result.get("camera_angle")
                camera_location= result.get("camera_location")
                camera_brand= result.get("camera_brand")
                camera_model_no= result.get("camera_model_no")
                camera_barcode= result.get("camera_barcode")
                camera_status= result.get("camera_status")
                camera_remarks= result.get("camera_remarks")
                cx= result.get("cx")
                cy= result.get("cy")
                # date_created= result.get("date_created")
                # date_updated= result.get("date_updated")
                format_response= ""

                if camera_id or camera_type or camera_subtype or camera_ip_address or camera_port_no or camera_username or camera_password or camera_angle or camera_location or camera_brand or camera_model_no or camera_barcode or camera_status or camera_remarks or cx or cy:
                    if id:
                        text= f"ID: {id}{self.table_code["cctv_camera"]}"
                        self.response.append(text)
                    if camera_id:
                        text= f"Camera Name: {camera_id}"
                        self.response.append(text)
                    if camera_type:
                        text= f"Camera Type: {camera_type}"
                        self.response.append(text)
                    if camera_subtype:
                        text= f"Camera Subtype: {camera_subtype}"
                        self.response.append(text)

                    if camera_ip_address:
                        text= f"IP Address: {camera_ip_address}"
                        self.response.append(text)
                    
                    if camera_port_no:
                        text= f"Port No.: {camera_port_no}"
                        self.response.append(text)
                    
                    if camera_username:
                        text= f"Username: {camera_username}"
                        self.response.append(text)

                    if camera_password:
                        text= f"Password: {camera_password}"
                        self.response.append(text)
                    
                    if camera_angle:
                        text= f"Angle: {camera_angle}"
                        self.response.append(text)
                    
                    if camera_location:
                        text= f"Location: {camera_location}"
                        self.response.append(text)

                    if camera_brand:
                        text= f"Brand: {camera_brand}"
                        self.response.append(text)
                    
                    if camera_model_no:
                        text= f"Model No.: {camera_model_no}"
                        self.response.append(text)
                    
                    if camera_barcode:
                        text= f"Barcode: {camera_barcode}"
                        self.response.append(text)
                    
                    if camera_status:
                        text= f"Status: {camera_status}"
                        self.response.append(text)
                    
                    if camera_remarks:
                        text= f"Remarks: {camera_remarks}"
                        self.response.append(text)
                    
                    if cx:
                        text= f"X-Coordinate: {cx}"
                        self.response.append(text)
                    
                    if cy:
                        text= f"Y-Coordinate: {cy}"
                        self.response.append(text)

                    for res in self.response:
                        format_response+= f"{res}\n"

                    result= f"---{camera_id.upper()}---\n{format_response}\n"
                    self.final_result += result
                    self.container_for_output.append(True)
                    self.response= []
                else:
                    return False
            return False
        except Exception as e:
            pass

    def finalOutput(self, query):
        self.final_result=""
        if query.lower().startswith("id"):
            details, image_path= self.database.forID(query.lower())
            # print(f"Details: {details}\nImage Path: {image_path}")
            return details,image_path
        else:
            self.database.getPreposition(query)
            # self.database.getCoordinatingConjunction(query)
            self.equipmentEntry(query)
            self.ipAddress(query)
            self.ipNetwork(query)
            self.ISP(query)
            self.routerA(query)
            self.cctvCamera(query)
            image_path= self.cctvLocation(query)

            if len(self.container_for_output) != 0:
                self.container_for_output= []
                if len(image_path) != 0:
                    return f"{self.final_result}\nYou can use ID no. for more details by typing\nID <id no.>", image_path #image_path contains final result as well
                
                else:
                    return f"{self.final_result}\nYou can use ID no. for more details by typing\nID <id no.>", {}
                
            else:
                return "Sorry, we couldn't find any results. Could you clarify what you're looking for?", {}

if __name__ == "__main__":
    showData= SHOWDATA()
    run_pattern= showData.runPattern()
    # while True:
    #         query= str(input("Query: "))
    #         # query= "id 3e"
    #         x= showData.finalOutput(query)
    #         print(x)
    while True:
        BOT_TOKEN = "8020836598:AAGjP_dYZqUsY5GlTDsOd_hTX0DLkixGdpM"
        bot = telebot.TeleBot(BOT_TOKEN)
        try:

            @bot.message_handler(func=lambda message: True)
            def instant_reply(message):
                try:
                    query= vars(message)
                    query= query["text"]
                    response, images_path= showData.finalOutput(query)
                    print(f"Response: {response}\nImages Path: {images_path}")
                    if len(images_path) != 0:
                        for img_path, description in images_path.items():
                            img_path= img_path[3:].replace("maps","maps_output")
                            with open(img_path, "rb") as photo:
                                bot.send_photo(message.chat.id, photo, caption=description)
                    else:
                        bot.reply_to(message, response)
                
                    # print(message['text'])
                except Exception as e:
                    pass
            print("Bot is live...\nDO NOT CLOSE THIS WINDOW")
            bot.infinity_polling()
        except Exception as e:
            pass
            



