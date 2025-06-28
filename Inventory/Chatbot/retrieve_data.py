import mysql.connector
import nltk
from nltk import word_tokenize, pos_tag
import telebot
from telegramAPI import TelegramBot

class DATABASE:
    def __init__(self):
        try:
            self.conn = mysql.connector.connect(host="127.0.0.1", user="root", database="wifi_inventory")
            self.cursor = self.conn.cursor()
            self.botStatus()
            self.description= ""
            self.prepositions= []
            self.preposition= ""
            self.column_used= ""
            self.list_return_value= []
            self.add_1= 1

        except Exception as e:
            print(e)
            # BOT_TOKEN = "8020836598:AAGjP_dYZqUsY5GlTDsOd_hTX0DLkixGdpM"
            # bot = telebot.TeleBot(BOT_TOKEN)

            # @bot.message_handler(func=lambda message: True)
            # def handle_message(message):
            #     chat_id = message.chat.id
            #     text = "Thanks for messaging me!"
            #     bot.send_message(chat_id, text)

            # bot.polling()
                        # print()

    def botStatus(self):
        telegrambot= TelegramBot()
        telegrambot.notifyMe("Bot is Live...")

    def getPreposition(self,query):
        try:
            self.prepositions= []
            sentence = query
            tokens = word_tokenize(sentence)
            tagged = pos_tag(tokens)

            # Filter for prepositions
            self.prepositions = [word for word, tag in tagged if tag == 'IN']
            self.preposition= [self.prepositions[-1]][0]
        except Exception as e:
            pass

    def getCoordinatingConjunction(self, query):
        sentence = query
        tokens = word_tokenize(sentence)
        tagged = pos_tag(tokens)

        # Filter for coordinating conjunction
        for word, tag in tagged:
            if tag == 'CC':
                sentence= sentence.replace(word, ",")
        return sentence
        # cc = [word for word, tag in tagged if tag == 'CC']
        # return cc

    def equipEntry(self, users_input):
        self.conn.cmd_refresh(1) # this will update the connection if theres a changes in the database
        users_input= users_input.lower()
        return_value = { "id":"","category":"","description": "", "model_no": "","barcode": "","specifications": "","status": "","remarks": ""}

        column_category= ["category","catagory","categary","categroy","catgory","cetegory","cateogry"]
        column_description= ["description","descreption","discription","descriptin","descriptiom","descrption","desription","decription"]
        column_model= ["model number","model num","modelnumber.","modelnum","modelno.","model no.","model no", "modelnom",
                       "model nomber", "modelnum.", "model num.","modle number","model numbr","model nuber","model nmbr","modle num"," model id", "model"]
        column_barcode= ["barcode","barcde","bacrode","barcdoe","barkode","barcoe","barcod","bacode","barc0de","bar code"]
        column_specific= ["specifications","specifcations","specifiactions","specifcaitons","specifactions","specifcation",
                          "specfications","specsifications","speciflcations","spec1fications","specif1cations","specifications_",
                          "specifications-","specificationss","specific","speci.", "specific", "speci"]
        column_status= ["status","stats","stat","statos","istatus","sttaus","staus","statu","ststus","stauts","statuz","statys","statuus","sttatus"]
        column_remarks= ["remarks","remark","remmark","remmarks","remraks","remaks","remrks","remakrs","remarcks","remarx","remarqs","remarcs","remarcks"]

        try:    #getting the users intent (self.description)                
            if self.preposition in users_input:
                index_position= users_input[users_input.index(self.preposition)+len(self.preposition):] #
                self.description= index_position.lstrip()   
                result= self.getCoordinatingConjunction(self.description)+','
                description= ""
                col_list= []
                self.list_return_value= []
                merged= {}

                # getting the hostname 
                for char in result:
                    if char == ',':
                        description= description.lstrip() #remove whitespace at the beginning
                        description= description.rstrip() #remove whitespace at the end
                        col_list.append(description)
                        description= ""
                        pass
                    else:
                        description+=char          

                #getting the user intent ("model number")
                for word in col_list:
                    self.description= word
                    for words in column_category: # to fix
                        if words in users_input:
                            self.column_used= "Category"
                            query = f"SELECT ee.id, e.name AS category, ee.description FROM equipment_entry ee JOIN equipment e ON ee.eid = e.id WHERE ee.description LIKE '%{self.description}%';"
                            self.cursor.execute(query)
                            result = self.cursor.fetchall()
                            for row in result:
                                item_id= row[0]
                                if item_id not in merged:
                                    merged[item_id] = {
                                        "id": row[0],
                                        "category": row[1],
                                        "description": row[2],
                                        "model_no":"",
                                        "barcode": "",
                                        "specifications": "",
                                        "status": "",
                                        "remarks": ""
                                    }
                                else:
                                    merged[item_id]["category"] = row[1]
                            break

                    for words in column_description:
                        if words in users_input:
                            self.column_used= "Description"
                            query= f"SELECT id, description FROM equipment_entry WHERE description LIKE '%{self.description}%';"
                            self.cursor.execute(query)
                            result = self.cursor.fetchall()
                            for row in result:
                                item_id= row[0]
                                if item_id not in merged:
                                    merged[item_id] = {
                                        "id": row[0],
                                        "category": "",
                                        "description": row[1],
                                        "model_no":"",
                                        "barcode": "",
                                        "specifications": "",
                                        "status": "",
                                        "remarks": ""
                                    }
                                else:
                                    merged[item_id]["description"] = row[1]
                            break
                    
                    for words in column_model:
                        if words in users_input:
                            self.column_used= "Model Number"
                            query= f"SELECT id, description, model_no FROM equipment_entry WHERE description LIKE '%{self.description}%';"
                            self.cursor.execute(query)
                            result = self.cursor.fetchall()
                            for row in result:
                                item_id= row[0]
                                if item_id not in merged:
                                    merged[item_id] = {
                                        "id": row[0],
                                        "category": "",
                                        "description": row[1],
                                        "model_no": row[2],
                                        "barcode": "",
                                        "specifications": "",
                                        "status": "",
                                        "remarks": ""
                                    }
                                else:
                                    merged[item_id]["model_no"] = row[2]

                            # self.list_return_value= list(merged.values())
                            break

                            # self.column_used= "Model Number"
                            # merged= {}
                            # query= f"SELECT id, description, model_no FROM equipment_entry WHERE description LIKE '%{self.description}%';"
                            # self.cursor.execute(query)
                            # result = self.cursor.fetchall()
                            # # return_value["id"]= result[0][0]
                            # for row in result:
                            #     return_value= {"id":row[0],"category":"","description":row[1],"model_no": row[2], "barcode":"", "specifications":"", "status":"", "remarks":""}
                            #     # return_value.update({"id":row[0],"category":"","description":row[1],"model_no": row[2], "barcode":"", "specifications":"", "status":"", "remarks":""})
                            #     self.list_return_value.append(return_value.copy())
                            #     # return_value['id']=row[0]
                            #     # return_value['description']=row[1]
                            #     # return_value['model_no']=row[2]
                            # break
                    
                    for words in column_barcode:
                        if words in users_input:
                            self.column_used= "Barcode"
                            query= f"SELECT id, description, barcode FROM equipment_entry WHERE description LIKE '%{self.description}%';"
                            self.cursor.execute(query)
                            result = self.cursor.fetchall()
                            for row in result:
                                item_id= row[0]
                                if item_id not in merged:
                                    merged[item_id] = {
                                        "id": row[0],
                                        "category": "",
                                        "description": row[1],
                                        "model_no": row[2] ,
                                        "barcode": "",
                                        "specifications": "",
                                        "status": "",
                                        "remarks": ""
                                    }
                                else:
                                    merged[item_id]["barcode"] = row[2]
                            break
                       
                    for words in column_specific:
                        if words in users_input:
                            self.column_used= "Specifications"
                            query= f"SELECT id, description, specifications FROM equipment_entry WHERE description LIKE '%{self.description}%';"
                            self.cursor.execute(query)
                            result = self.cursor.fetchall()
                            for row in result:
                                item_id= row[0]
                                if item_id not in merged:
                                    merged[item_id] = {
                                        "id": row[0],
                                        "category": "",
                                        "description": row[1],
                                        "model_no": "",
                                        "barcode": "",
                                        "specifications": row[2],
                                        "status": "",
                                        "remarks": ""
                                    }
                                else:
                                    merged[item_id]["specifications"] = row[2]
                            break

                    for words in column_status:
                        if words in users_input:
                            self.column_used= "Status"
                            query= f"SELECT id ,description, status FROM equipment_entry WHERE description LIKE '{self.description}%';"
                            self.cursor.execute(query)
                            result = self.cursor.fetchall()
                            for row in result:
                                item_id= row[0]
                                if item_id not in merged:
                                    merged[item_id] = {
                                        "id": row[0],
                                        "category": "",
                                        "description": row[1],
                                        "model_no": "",
                                        "barcode": "",
                                        "specifications": "",
                                        "status": row[2],
                                        "remarks": ""
                                    }
                                else:
                                    merged[item_id]["status"] = row[2]
                            break
                    
                    for words in column_remarks:
                        if words in users_input:
                            self.column_used= "Remarks"
                            query= f"SELECT id, description, remarks FROM equipment_entry WHERE description LIKE '{self.description}%';"
                            self.cursor.execute(query)
                            result = self.cursor.fetchall()
                            for row in result:
                                item_id= row[0]
                                if item_id not in merged:
                                    merged[item_id] = {
                                        "id": row[0],
                                        "category": "",
                                        "description": row[1],
                                        "model_no": "",
                                        "barcode": "",
                                        "specifications": "",
                                        "status": "",
                                        "remarks": row[2]
                                    }
                                else:
                                    merged[item_id]["remarks"] = row[2]
                            break

                self.list_return_value= list(merged.values())
                return self.list_return_value
                        
            else:
                self.list_return_value= list(merged.values())
                return self.list_return_value #no preposition word
        except Exception as e:
            # print(e)
            self.list_return_value= list(merged.values())
            return self.list_return_value

    def ipAdd(self, users_input): 
        users_input= users_input.lower()
        return_value= {"id":"","network_name":"","ip":"", "subnet":"", "hostname":"", "site":"", "server":"", "status":"", "remarks":"", "webmgmpt":"", "username":"", "password":""}


        column_ip= ["ip","ip add","ip address","ip adress","ip adress","ip addres","ipaddress","ip adrss","ip adderss"]
        column_network= ["network","netwrk","netwrok","netork","netwrk","neetwork","netowrk","newtork","network name","networkname"]
        column_subnet= ["subnet","subnett","subnit","subent","subnnet","sunbet","submnet","sobnet"]
        column_hostname= ["hostname","hostnmae","hosntame","hostame","hosname","hostnme","hostnmame","hoastname","h0stname","hustname","hostnme","hostnam","hostnsme"]
        column_site= ["site","siet","sit","siite","sitee","sote","syte","s1te"]
        column_server= ["server","serer","sever","servr","srver","serber","serveer","servver","serfer"]
        column_status= ["status","stats","stat","statos","istatus","sttaus","staus","statu","ststus","stauts","statuz","statys","statuus","sttatus"]
        column_remarks= ["remarks","remark","remmark","remmarks","remraks","remaks","remrks","remakrs","remarcks","remarx","remarqs","remarcs","remarcks"]
        column_webmgmtpt= ["webmgmtpt","webmgmt","webmngmt","webmgmnt","webmgmtpt","webmgt","webmgmtp","webmangmt","webmngmnt","webport","web port"]
        column_username= ["username","usrename","usernmae","uesrname","usermane","usernme","userame","usernmae","usrname","usernmae","usernmae","usernam"]
        column_password= ["password","pasword","passwrod","paswword","passord","passwor","passwrd","paswordd","passw0rd","pswrd"]

        try:
            #getting the users intent (self.description)
            if self.preposition in users_input:
                index_position= users_input[users_input.index(self.preposition)+len(self.preposition):]
                self.description= index_position.lstrip()
                result= self.getCoordinatingConjunction(self.description)+','
                description= ""
                col_list= []
                self.list_return_value= []
                merged= {}

                # getting the hostname 
                for char in result:
                    if char == ',':
                        description= description.lstrip() #remove whitespace at the beginning
                        description= description.rstrip() #remove whitespace at the end
                        col_list.append(description)
                        description= ""
                        pass
                    else:
                        description+=char          

                #getting the user intent ("model number")
                for word in col_list:
                    self.description= word
                    if self.description.startswith("1") or self.description.startswith("2"):
                        col_used= "ip" 
                    else:
                        col_used= "hostname"

                    for words in column_ip:
                        if words in users_input:
                            self.column_used= "IP Address"
                            query= f"SELECT id, hostname, ip FROM ip_address WHERE {col_used} LIKE '%{self.description}%';"
                            self.cursor.execute(query)
                            result = self.cursor.fetchall()
                            for row in result:
                                item_id= row[0]
                                if item_id not in merged:
                                    merged[item_id] = {"id":row[0],"network_name":"","ip":row[2], "subnet":"", "hostname":row[1], "site":"", "server":"", "status":"", "remarks":"", "webmgmpt":"", "username":"", "password":""}
                                else:
                                    merged[item_id]["ip"] = row[2]
                            break

                    for words in column_network:
                        if words in users_input:
                            # query = f"SELECT ee.id, e.name AS category, ee.description FROM equipment_entry ee JOIN equipment e ON ee.eid = e.id WHERE ee.description LIKE '%{self.description}%';"
                            self.column_used= "Network Name"
                            # query= f"SELECT id, hostname, name FROM ip_network WHERE id=(SELECT nid FROM ip_address WHERE {col_used} LIKE '{self.description}%');"
                            query = f"SELECT ia.id, i_n.name AS Network_Name, ia.hostname FROM ip_address ia JOIN ip_network i_n ON ia.nid = i_n.id WHERE ia.hostname LIKE '%{self.description}%';"
                            self.cursor.execute(query)
                            result = self.cursor.fetchall()
                            for row in result:
                                item_id= row[0]
                                if item_id not in merged:
                                    merged[item_id] = {"id":row[0],"network_name":row[1],"ip":"", "subnet":"", "hostname":row[2], "site":"", "server":"", "status":"", "remarks":"", "webmgmpt":"", "username":"", "password":""}
                                else:
                                    merged[item_id]["network_name"] = row[1]
                            break
                    
                    for words in column_subnet: 
                        if words in users_input:
                            self.column_used= "Subnet"
                            query= f"SELECT id, hostname, subnet FROM ip_address WHERE {col_used} LIKE '%{self.description}%';"
                            self.cursor.execute(query)
                            result = self.cursor.fetchall()
                            for row in result:
                                item_id= row[0]
                                if item_id not in merged:
                                    merged[item_id] = {"id":row[0],"network_name":"","ip":"", "subnet":row[2], "hostname":row[1], "site":"", "server":"", "status":"", "remarks":"", "webmgmpt":"", "username":"", "password":""}
                                else:
                                    merged[item_id]["subnet"] = row[2]
                            break

                    for words in column_hostname:
                        if words in users_input:
                            self.column_used= "hostname"
                            query= f"SELECT id, hostname FROM ip_address WHERE {col_used} LIKE '%{self.description}%';"
                            self.cursor.execute(query)
                            result = self.cursor.fetchall() 
                            for row in result:
                                item_id= row[0]
                                if item_id not in merged:
                                    merged[item_id] = {"id":row[0],"network_name":"","ip":"", "subnet":"", "hostname":row[1], "site":"", "server":"", "status":"", "remarks":"", "webmgmpt":"", "username":"", "password":""}
                                else:
                                    merged[item_id]["hostname"] = row[1]
                            break
                    
                    for words in column_site: 
                        if words in users_input:
                            self.column_used= "Site"
                            query= f"SELECT id, hostname, site FROM ip_address WHERE {col_used} LIKE '%{self.description}%';"
                            self.cursor.execute(query)
                            result = self.cursor.fetchall()
                            for row in result:
                                item_id= row[0]
                                if item_id not in merged:
                                    merged[item_id] = {"id":row[0],"network_name":"","ip":"", "subnet":"", "hostname":row[1], "site":row[2], "server":"", "status":"", "remarks":"", "webmgmpt":"", "username":"", "password":""}
                                else:
                                    merged[item_id]["site"] = row[2]
                            break

                    for words in column_server:
                        if words in users_input:
                            self.column_used= "Server"
                            query= f"SELECT id, hostname, server FROM ip_address WHERE {col_used} LIKE '%{self.description}%';"
                            self.cursor.execute(query)
                            result = self.cursor.fetchall()
                            for row in result:
                                item_id= row[0]
                                if item_id not in merged:
                                    merged[item_id] = {"id":row[0],"network_name":"","ip":"", "subnet":"", "hostname":row[1], "site":"", "server":row[2], "status":"", "remarks":"", "webmgmpt":"", "username":"", "password":""}
                                else:
                                    merged[item_id]["server"] = row[2]
                            break
                    
                    for words in column_status:
                        if words in users_input:
                            self.column_used= "Status"
                            query= f"SELECT id, hostname, status FROM ip_address WHERE {col_used} LIKE '%{self.description}%';"
                            self.cursor.execute(query)
                            result = self.cursor.fetchall()
                            for row in result:
                                item_id= row[0]
                                if item_id not in merged:
                                    merged[item_id] = {"id":row[0],"network_name":"","ip":"", "subnet":"", "hostname":row[1], "site":"", "server":"", "status":row[2], "remarks":"", "webmgmpt":"", "username":"", "password":""}
                                else:
                                    merged[item_id]["status"] = row[2]
                            break
                    
                    for words in column_remarks:
                        if words in users_input:
                            self.column_used= "Remarks"
                            query= f"SELECT id, hostname, remarks FROM ip_address WHERE {col_used} LIKE '%{self.description}%';"
                            self.cursor.execute(query)
                            result = self.cursor.fetchall()
                            for row in result:
                                item_id= row[0]
                                if item_id not in merged:
                                    merged[item_id] = {"id":row[0],"network_name":"","ip":"", "subnet":"", "hostname":row[1], "site":"", "server":"", "status":"", "remarks":row[2], "webmgmpt":"", "username":"", "password":""}
                                else:
                                    merged[item_id]["remarks"] = row[2]
                            break

                    for words in column_webmgmtpt:
                        if words in users_input:
                            self.column_used= "Web Management Port"
                            query= f"SELECT id, hostname, webmgmtpt FROM ip_address WHERE {col_used} LIKE '%{self.description}%';"
                            self.cursor.execute(query)
                            result = self.cursor.fetchall()
                            for row in result:
                                item_id= row[0]
                                if item_id not in merged:
                                    merged[item_id] = {"id":row[0],"network_name":"","ip":"", "subnet":"", "hostname":row[1], "site":"", "server":"", "status":"", "remarks":"", "webmgmpt":row[2], "username":"", "password":""}
                                else:
                                    merged[item_id]["webmgmpt"] = row[2]
                            break

                    for words in column_username:
                        if words in users_input:
                            self.column_used= "Username"
                            query= f"SELECT id, hostname, username FROM ip_address WHERE {col_used} LIKE '%{self.description}%';"
                            self.cursor.execute(query)
                            result = self.cursor.fetchall()
                            for row in result:
                                item_id= row[0]
                                if item_id not in merged:
                                    merged[item_id] = {"id":row[0],"network_name":"","ip":"", "subnet":"", "hostname":row[1], "site":"", "server":"", "status":"", "remarks":"", "webmgmpt":"", "username":row[2], "password":""}
                                else:
                                    merged[item_id]["username"] = row[2]
                            break

                    for words in column_password:
                        if words in users_input:
                            self.column_used= "Password"
                            query= f"SELECT id, hostname, password FROM ip_address WHERE {col_used} LIKE '%{self.description}%';"
                            self.cursor.execute(query)
                            result = self.cursor.fetchall()
                            for row in result:
                                item_id= row[0]
                                if item_id not in merged:
                                    merged[item_id] = {"id":row[0],"network_name":"","ip":"", "subnet":"", "hostname":row[1], "site":"", "server":"", "status":"", "remarks":"", "webmgmpt":"", "username":"", "password":row[2]}
                                else:
                                    merged[item_id]["password"] = row[2]
                            break

                self.list_return_value= list(merged.values())
                return self.list_return_value
                        
            else:
                self.list_return_value= list(merged.values())
                return self.list_return_value
        except:
            self.list_return_value= list(merged.values())
            return self.list_return_value
        
    def ipNet(self, users_input): 
        users_input= users_input.lower()
        return_value= {"id":"","router_name":"","name":"", "from":"", "to":"", "subnet":"", "router":""}

        column_router= ["router","ruter","roter","rooter","rounter","routerr","roueter","reouter","router name","routers name","routername"] 
        column_netname= ["network","netwrk","netwrok","netork","netwrk","neetwork","netowrk","newtork","network name","networkname","name","nam","anme"]
        column_from_to= ["range", "dhcp range", "dhcprange"]
        column_subnet= ["subnet","subnett","subnit","subent","subnnet","sunbet","submnet","sobnet"]
        

        try:    #getting the users intent (self.description)
            if self.preposition in users_input:
                index_position= users_input[users_input.index(self.preposition)+len(self.preposition):]
                self.description= index_position.lstrip()
                result= self.getCoordinatingConjunction(self.description)+','
                description= ""
                col_list= []
                self.list_return_value= []
                merged= {}

                # getting the hostname 
                for char in result:
                    if char == ',':
                        description= description.lstrip() #remove whitespace at the beginning
                        description= description.rstrip() #remove whitespace at the end
                        col_list.append(description)
                        description= ""
                        pass
                    else:
                        description+=char          

                #getting the user intent ("model number")
                for word in col_list:
                    self.description= word

                    for words in column_router:
                        if words in users_input:
                            self.column_used= "Router Name"
                            # query= f"SELECT name FROM routers WHERE id=(SELECT rid FROM ip_network WHERE name LIKE '{self.description}%');"
                            query= f"SELECT ip_n.id, ip_n.name, r.name AS Router_name FROM ip_network ip_n JOIN routers r ON ip_n.rid = r.id WHERE ip_n.name LIKE '%{self.description}%';"
                            self.cursor.execute(query)
                            result = self.cursor.fetchall()
                            for row in result:
                                item_id= row[0]
                                if item_id not in merged:
                                    merged[item_id] = {"id":row[0],"router_name":row[2],"name":row[1], "from":"", "to":"", "subnet":"", "router":""}
                                else:
                                    merged[item_id]["router_name"] = row[2]
                            break

                    for words in column_netname:
                        if words in users_input:
                            self.column_used= "Name"
                            query= f"SELECT id, name FROM ip_network WHERE name LIKE '%{self.description}%';"
                            self.cursor.execute(query)
                            result = self.cursor.fetchall()
                            for row in result:
                                item_id= row[0]
                                if item_id not in merged:
                                    merged[item_id] = {"id":row[0],"router_name":"","name":row[1], "from":"", "to":"", "subnet":"", "router":""}
                                else:
                                    merged[item_id]["name"] = row[1]
                            break

                    for words in column_from_to:
                        if words in users_input:
                            self.column_used= "Range"
                            query= f"SELECT id, name, `from`, `to` FROM ip_network WHERE name LIKE '%{self.description}%';"
                            self.cursor.execute(query)
                            result = self.cursor.fetchall()
                            for row in result:
                                item_id= row[0]
                                if item_id not in merged:
                                    merged[item_id] = {"id":row[0],"router_name":"","name":row[1], "from":row[2], "to":row[3], "subnet":"", "router":""}
                                else:
                                    merged[item_id]["from"] = row[2]
                                    merged[item_id]["to"] = row[3]
                            break
                    
                    for words in column_subnet:
                        if words in users_input:
                            self.column_used= "Subnet"
                            query= f"SELECT id, name, subnet FROM ip_network WHERE name LIKE '%{self.description}%';"
                            self.cursor.execute(query)
                            result = self.cursor.fetchall()
                            for row in result:
                                item_id= row[0]
                                if item_id not in merged:
                                    merged[item_id] = {"id":row[0],"router_name":"","name":row[1], "from":"", "to":"", "subnet":row[2]}
                                else:
                                    merged[item_id]["subnet"] = row[2]
                            break

                self.list_return_value= list(merged.values())
                return self.list_return_value
                        
            else:
                self.list_return_value= list(merged.values())
                return self.list_return_value
        except Exception as e:
            # print(e)
            self.list_return_value= list(merged.values())
            return self.list_return_value

    def isp(self, users_input): 
        users_input= users_input.lower()
        return_value= {"id":"","isp_name":"", "name":"", "wan_ip":"", "subnet":"", "gateway":"", "dns1":"", "dns2":"", "webmgmtpt":""}

        column_ispname= ["isp", "internet","internet service provider", "internet service", "internet servce","ispname","isp name"]
        column_name= ["name","nam","anme"]
        column_wanip= ["wan ip","wanip","ip","wan"]
        column_subnet= ["subnet","subnett","subnit","subent","subnnet","sunbet","submnet","sobnet"]
        column_gateway= ["gateway","gatway","getway","gtaeway","gatwey","gatewayy","gaeetway","gatweay"]
        column_dns= ["dns","dns 1","dns1","dns 2","dns2"]
        column_webmgmtpt= ["webmgmtpt","webmgmt","webmngmt","webmgmnt","webmgmtpt","webmgt","webmgmtp","webmangmt","webmngmnt", "web port", "webport"]
        isp= ["pldt","globe","converge"]

        try:    #getting the users intent (self.description)
            if self.preposition in users_input:
                index_position= users_input[users_input.index(self.preposition)+len(self.preposition):]
                self.description= index_position.lstrip()
                result= self.getCoordinatingConjunction(self.description)+','
                description= ""
                col_list= []
                self.list_return_value= []
                merged= {}

                # getting the hostname 
                for char in result:
                    if char == ',':
                        description= description.lstrip() #remove whitespace at the beginning
                        description= description.rstrip() #remove whitespace at the end
                        col_list.append(description)
                        description= ""
                        pass
                    else:
                        description+=char          

                #getting the user intent ("model number")
                for word in col_list:
                    self.description= word

                    if self.description in isp:
                        col_used= "isp_name"
                    else:
                        col_used= "name"

                    # print(f"Col used: {col_used}, Description: {self.description}")

                    for words in column_ispname:
                        if words in users_input:
                            self.column_used= "ISP"
                            query= f"SELECT id, name, isp_name FROM isp WHERE {col_used} LIKE '%{self.description}%';"
                            self.cursor.execute(query)
                            result = self.cursor.fetchall()
                            for row in result:
                                item_id= row[0]
                                if item_id not in merged:
                                    merged[item_id] = {"id":row[0],"isp_name":row[2], "name":row[1], "wan_ip":"", "subnet":"", "gateway":"", "dns1":"", "dns2":"", "webmgmtpt":""}
                                else:
                                    merged[item_id]["isp_name"] = row[2]
                            break
                    
                    for words in column_name:
                        if words in users_input:
                            self.column_used= "Name"
                            query= f"SELECT id, name FROM isp WHERE {col_used} LIKE '%{self.description}%';"
                            self.cursor.execute(query)
                            result = self.cursor.fetchall()
                            for row in result:
                                item_id= row[0]
                                if item_id not in merged:
                                    merged[item_id] = {"id":row[0],"isp_name":"", "name":row[1], "wan_ip":"", "subnet":"", "gateway":"", "dns1":"", "dns2":"", "webmgmtpt":""}
                                else:
                                    merged[item_id]["name"] = row[1]
                            break
                    
                    for words in column_wanip:
                        if words in users_input:
                            self.column_used= "WAN IP"
                            query= f"SELECT id, name, wan_ip FROM isp WHERE {col_used} LIKE '%{self.description}%';"
                            self.cursor.execute(query)
                            result = self.cursor.fetchall()
                            for row in result:
                                item_id= row[0]
                                if item_id not in merged:
                                    merged[item_id] = {"id":row[0],"isp_name":"", "name":row[1], "wan_ip":"", "subnet":"", "gateway":"", "dns1":"", "dns2":"", "webmgmtpt":""}
                                else:
                                    merged[item_id]["name"] = row[1]
                            break

                    for words in column_subnet:
                        if words in users_input:
                            self.column_used= "Subnet"
                            query= f"SELECT id, name, subnet FROM isp WHERE {col_used} LIKE '%{self.description}%';"
                            self.cursor.execute(query)
                            result = self.cursor.fetchall()
                            for row in result:
                                item_id= row[0]
                                if item_id not in merged:
                                    merged[item_id] = {"id":row[0],"isp_name":"", "name":row[1], "wan_ip":"", "subnet": row[2], "gateway":"", "dns1":"", "dns2":"", "webmgmtpt":""}
                                else:
                                    merged[item_id]["subnet"] = row[2]
                            break
                    
                    for words in column_gateway:
                        if words in users_input:
                            self.column_used= "Gateway"
                            query= f"SELECT id, name, gateway FROM isp WHERE {col_used} LIKE '%{self.description}%';"
                            self.cursor.execute(query)
                            result = self.cursor.fetchall()
                            for row in result:
                                item_id= row[0]
                                if item_id not in merged:
                                    merged[item_id] = {"id":row[0],"isp_name":"", "name":row[1], "wan_ip":"", "subnet": "", "gateway":row[2], "dns1":"", "dns2":"", "webmgmtpt":""}
                                else:
                                    merged[item_id]["gateway"] = row[2]
                            break

                    for words in column_dns: #
                        if words in users_input:
                            self.column_used= "DNS"
                            query= f"SELECT id, name, dns1, dns2 FROM isp WHERE {col_used} LIKE '%{self.description}%';"
                            self.cursor.execute(query)
                            result = self.cursor.fetchall()
                            dns1= ""
                            dns2= ""
                            for row in result:
                                dns1= row[2]
                                dns2= row[3]
                                if dns1 != '-':
                                    dns1= row[2]
                                else:
                                    dns1= "None"
                                
                                if dns2 != '-':
                                    dns2= row[3]
                                else:
                                    dns2= "None"

                                item_id= row[0]
                                if item_id not in merged:
                                    merged[item_id] = {"id":row[0],"isp_name":"", "name":row[1], "wan_ip":"", "subnet": "", "gateway":"", "dns1":dns1, "dns2":dns2, "webmgmtpt":""}
                                else:
                                    merged[item_id]["dns1"] = dns1
                                    merged[item_id]["dns2"] = dns2
                            break
                    
                    for words in column_webmgmtpt:
                        if words in users_input:
                            self.column_used= "Web Management Port"
                            query= f"SELECT id, name, webmgmtpt FROM isp WHERE {col_used} LIKE '%{self.description}%';"
                            self.cursor.execute(query)
                            result = self.cursor.fetchall()
                            webport= ""
                            for row in result:
                                webport= row[2]
                                if webport == '-':
                                    webport= "None"
                                item_id= row[0]
                                if item_id not in merged:
                                    merged[item_id] = {"id":row[0],"isp_name":"", "name":row[1], "wan_ip":"", "subnet": "", "gateway":"", "dns1":"", "dns2":"", "webmgmtpt":webport}
                                else:
                                    merged[item_id]["webmgmtpt"] = webport
                            break
                
                self.list_return_value= list(merged.values())
                return self.list_return_value
            else:
                self.list_return_value= list(merged.values())
                return self.list_return_value
        except Exception as e:
            # print(e)
            self.list_return_value= list(merged.values())
            return self.list_return_value

    def routerB(self, users_input):
        users_input= users_input.lower()
        return_value= {"id":"","name":"", "ip":"", "subnet":"", "wan1":"", "wan2":"", "active":""}

        column_name= ["name","nam","anme","router name", "routername"]
        column_ip= ["ip","ip add","ip address","ip adress","ip adress","ip addres","ipaddress","ip adrss","ip adderss"]
        column_subnet= ["subnet","subnett","subnit","subent","subnnet","sunbet","submnet","sobnet","subnrt"]
        column_wan= ["wan","wan1","wan 1","wan2","wan 2"]
        column_active= ["current", "curr", "current isp", "curr isp"]

        try:    #getting the users intent (self.description)
            if self.preposition in users_input:
                index_position= users_input[users_input.index(self.preposition)+len(self.preposition):]
                self.description= index_position.lstrip()
                result= self.getCoordinatingConjunction(self.description)+','
                description= ""
                col_list= []
                self.list_return_value= []
                merged= {}

                # getting the hostname 
                for char in result:
                    if char == ',':
                        description= description.lstrip() #remove whitespace at the beginning
                        description= description.rstrip() #remove whitespace at the end
                        col_list.append(description)
                        description= ""
                        pass
                    else:
                        description+=char          

                #getting the user intent ("model number")
                for word in col_list:
                    self.description= word

                    for words in column_name:
                        if words in users_input:
                            self.column_used= "Name"
                            query= f"SELECT id, name FROM routers WHERE name LIKE '%{self.description}%';"
                            self.cursor.execute(query)
                            result = self.cursor.fetchall()
                            for row in result:
                                item_id= row[0]
                                if item_id not in merged:
                                    merged[item_id] = {"id":row[0],"name":row[1], "ip":"", "subnet":"", "wan1":"", "wan2":"", "active":""}
                                else:
                                    merged[item_id]["name"] = row[1]
                            break
                    
                    for words in column_ip:
                        if words in users_input:
                            self.column_used= "IP"
                            query= f"SELECT id, name, ip FROM routers WHERE name LIKE '%{self.description}%';"
                            self.cursor.execute(query)
                            result = self.cursor.fetchall()
                            for row in result:
                                item_id= row[0]
                                if item_id not in merged:
                                    merged[item_id] = {"id":row[0],"name":row[1], "ip":row[2], "subnet":"", "wan1":"", "wan2":"", "active":""}
                                else:
                                    merged[item_id]["ip"] = row[2]
                            break
                    
                    for words in column_subnet:
                        if words in users_input:
                            self.column_used= "Subnet"
                            query= f"SELECT id, name, subnet FROM routers WHERE name LIKE '%{self.description}%';"
                            self.cursor.execute(query)
                            result = self.cursor.fetchall()
                            for row in result:
                                item_id= row[0]
                                if item_id not in merged:
                                    merged[item_id] = {"id":row[0],"name":row[1], "ip":"", "subnet":row[2], "wan1":"", "wan2":"", "active":""}
                                else:
                                    merged[item_id]["subnet"] = row[2]
                            break
                    
                    for words in column_wan:
                        if words in users_input:
                            self.column_used= "WAN"
                            query= f"SELECT id, name, wan1, wan2 FROM routers WHERE name LIKE '%{self.description}%';"
                            self.cursor.execute(query)
                            result = self.cursor.fetchall()
                            wan1= ""
                            wan2= ""
                            for row in result:
                                wan1= row[2]
                                wan2= row[3]
                                if wan1 != "-":
                                    query= f"SELECT isp_name FROM isp WHERE id={wan1}"
                                    self.cursor.execute(query)
                                    wan1_reslt = self.cursor.fetchall()[0][0]
                                else:
                                    wan1_reslt= "None"

                                if wan2 != "-":
                                    query= f"SELECT isp_name FROM isp WHERE id={wan2}"
                                    self.cursor.execute(query)
                                    wan2_reslt = self.cursor.fetchall()[0][0]
                                else:
                                    wan2_reslt= "None"

                                item_id= row[0]
                                if item_id not in merged:
                                    merged[item_id] = {"id":row[0],"name":row[1], "ip":"", "subnet":"", "wan1":wan1_reslt, "wan2":wan2_reslt, "active":""}
                                else:
                                    merged[item_id]["wan1"] = wan1_reslt
                                    merged[item_id]["wan2"] = wan2_reslt
                            break

                    for words in column_active:
                        if words in users_input:
                            self.column_used= "Active"
                            query1= f"SELECT id, name, active FROM routers WHERE name LIKE '%{self.description}%';"
                            self.cursor.execute(query1)
                            result = self.cursor.fetchall()
                            curr_isp= ""
                            for row in result:
                                curr_isp= row[2]
                                if curr_isp != "-":
                                    query= f"SELECT isp_name FROM isp WHERE id={curr_isp}"
                                    self.cursor.execute(query)
                                    isp_reslt = self.cursor.fetchall()[0][0]
                                else:
                                    isp_reslt= "None"

                                item_id= row[0]
                                if item_id not in merged:
                                    merged[item_id] = {"id":row[0],"name":row[1], "ip":"", "subnet":"", "wan1":"", "wan2":"", "active":isp_reslt}
                                else:
                                    merged[item_id]["active"] = isp_reslt
                            break
                self.list_return_value= list(merged.values())
                return self.list_return_value
            else:
                self.list_return_value= list(merged.values())
                return self.list_return_value
        except Exception as e:
            # print(e)
            self.list_return_value= list(merged.values())
            return self.list_return_value
        
    def cctvLocate(self, users_input):
        users_input= users_input.lower()
        return_value= {"id":"","map_location":"", "floorplan":"", "remarks":"", "camera_size":"", "data_created":"", "data_updated":""}
        column_floorplan= ["floor plan","floorplan", "layout"]
        column_remarks= ["remarks","remark","remmark","remmarks","remraks","remaks","remrks","remakrs","remarcks","remarx","remarqs","remarcs","remarcks"]
        column_camsize= ["camera size", "camerasize","cam size","camsize","camera_size"]
        try:
            if self.preposition in users_input:
                index_position= users_input[users_input.index(self.preposition)+len(self.preposition):]
                self.description= index_position.lstrip()
                result= self.getCoordinatingConjunction(self.description)+','
                description= ""
                col_list= []
                self.list_return_value= []
                merged= {}

                # getting the hostname 
                for char in result:
                    if char == ',':
                        description= description.lstrip() #remove whitespace at the beginning
                        description= description.rstrip() #remove whitespace at the end
                        col_list.append(description)
                        description= ""
                        pass
                    else:
                        description+=char          

                for word in col_list:
                    self.description= word

                    for words in column_floorplan:
                        if words in users_input:
                            self.column_used= "Floor Plan"
                            query= f"SELECT id, map_location, floorplan FROM cctv_location WHERE map_location LIKE '%{self.description}%';"
                            self.cursor.execute(query)
                            result = self.cursor.fetchall()
                            for row in result:
                                item_id= row[0]
                                if item_id not in merged:
                                    merged[item_id] = {"id":row[0],"map_location":row[1], "floorplan":row[2], "remarks":"", "camera_size":"", "data_created":"", "data_updated":""}
                                else:
                                    merged[item_id]["floorplan"] = row[2]
                            break

                    for words in column_remarks:
                        if words in users_input:
                            self.column_used= "Remarks"
                            query= f"SELECT id, map_location, remarks FROM cctv_location WHERE map_location LIKE '%{self.description}%';"
                            self.cursor.execute(query)
                            result = self.cursor.fetchall()
                            for row in result:
                                item_id= row[0]
                                if item_id not in merged:
                                    merged[item_id] = {"id":row[0],"map_location":row[1], "floorplan":"", "remarks":row[2], "camera_size":"", "data_created":"", "data_updated":""}
                                else:
                                    merged[item_id]["remarks"] = row[2]
                            break
                    
                    for words in column_camsize:
                        if words in users_input:
                            self.column_used= "Camera Size"
                            query= f"SELECT id, map_location, camera_size FROM cctv_location WHERE map_location LIKE '%{self.description}%';"
                            self.cursor.execute(query)
                            result = self.cursor.fetchall()
                            for row in result:
                                item_id= row[0]
                                if item_id not in merged:
                                    merged[item_id] = {"id":row[0],"map_location":row[1], "floorplan":"", "remarks":"", "camera_size":row[2], "data_created":"", "data_updated":""}
                                else:
                                    merged[item_id]["camera_size"] = row[2]
                            break

                self.list_return_value= list(merged.values())
                return self.list_return_value
            else:
                self.list_return_value= list(merged.values())
                return self.list_return_value

        except Exception as e:
            self.list_return_value= list(merged.values())
            return self.list_return_value
        
    def cctvCam(self, users_input):
        users_input= users_input.lower()
        return_value= {"id":"","camera_id":"", "camera_type":"", "camera_subtype":"", "camera_ip_address":"","camera_port_no":"","camera_username":"","camera_password":"","camera_angle":"","camera_location":"","camera_brand":"","camera_model_no":"","camera_barcode":"","camera_status":"","camera_remarks":"","cx":"","cy":"","date_created":"", "date_updated":""}
        
        column_camname= ["camera name","cam name","name","nam","anme"]
        column_camtype= ["camera type","camtype","cam type","type"]
        column_cam_subtype= ["camera subtype","cam subtype","camsubtype","subtype"]
        column_camip= ["camera ip address","cam ip address","cam ip add","camera ip","camera ip add","ip","ip add","ip address"]
        column_camport= ["camera port no","camera port","cam port no","cam port no.", "port no","port no.","port number","port num"]
        column_camusername= ["username","usrename","usernmae","uesrname","usermane","usernme","userame","usernmae","usrname","usernmae","usernmae","usernam"]
        column_campassword= ["password","pasword","passwrod","paswword","passord","passwor","passwrd","paswordd","passw0rd","pswrd"]
        column_camangnle= ["camera angle","cam angle","angle","anleg","angl","agle"]
        column_camlocation= ["camera location","camera loc","cam location","cam loc","location","locate","loc"]
        column_cambrand= ["camera brand","cam brand","cambrand","brand","brad","bradn"]
        column_cammodel= ["camera model","cam model","cammodel","camera mdel","cam del","model number","model num","modelnumber.","modelnum","modelno.","model no.","model no", "modelnom",
                       "model nomber", "modelnum.", "model num.","modle number","model numbr","model nuber","model nmbr","modle num"," model id", "model"]
        column_cambarcode= ["camera barcode","cam barcode","camera bar","camra barcode","barcode","barcde","bacrode","barcdoe","barkode","barcoe","barcod","bacode","barc0de","bar code"]
        column_camstatus= ["camera status","cam status","camera stats","cam stats","camera stats","status","stats","stat","statos","istatus","sttaus","staus","statu","ststus","stauts","statuz","statys","statuus","sttatus"]
        column_camremarks= ["remarks","remark","remmark","remmarks","remraks","remaks","remrks","remakrs","remarcks","remarx","remarqs","remarcs","remarcks"]
        column_camx= ["coordinates x","coordinate x","x","cordinates x","cordinate x","cx"]
        column_camy= ["coordinates y","coordinate y","cordinates y","cordinate y","cy"]

        try:
            if self.preposition in users_input:
                index_position= users_input[users_input.index(self.preposition)+len(self.preposition):]
                self.description= index_position.lstrip()
                result= self.getCoordinatingConjunction(self.description)+','
                description= ""
                col_list= []
                self.list_return_value= []
                merged= {}

                # getting the hostname 
                for char in result:
                    if char == ',':
                        description= description.lstrip() #remove whitespace at the beginning
                        description= description.rstrip() #remove whitespace at the end
                        col_list.append(description)
                        description= ""
                        pass
                    else:
                        description+=char          

                for word in col_list:
                    self.description= word
                    for words in column_camname:
                        if words in users_input:
                            self.column_used= "Camera Name"
                            query= f"SELECT id, camera_id FROM cctv_camera WHERE camera_id LIKE '%{self.description}%';"
                            self.cursor.execute(query)
                            result = self.cursor.fetchall()
                            for row in result:
                                item_id= row[0]
                                if item_id not in merged:
                                    merged[item_id] = {"id":row[0],"camera_id":row[1], "camera_type":"", "camera_subtype":"", "camera_ip_address":"","camera_port_no":"","camera_username":"","camera_password":"","camera_angle":"","camera_location":"","camera_brand":"","camera_model_no":"","camera_barcode":"","camera_status":"","camera_remarks":"","cx":"","cy":"","date_created":"", "date_updated":""}
                                else:
                                    merged[item_id]["camera_id"] = row[1]
                            break

                    for words in column_camtype:
                        if words in users_input:
                            self.column_used= "Camera Type"
                            query= f"SELECT id, camera_id, camera_type FROM cctv_camera WHERE camera_id LIKE '%{self.description}%';"
                            self.cursor.execute(query)
                            result = self.cursor.fetchall()
                            for row in result:
                                item_id= row[0]
                                if item_id not in merged:
                                    merged[item_id] = {"id":row[0],"camera_id":row[1], "camera_type":row[2], "camera_subtype":"", "camera_ip_address":"","camera_port_no":"","camera_username":"","camera_password":"","camera_angle":"","camera_location":"","camera_brand":"","camera_model_no":"","camera_barcode":"","camera_status":"","camera_remarks":"","cx":"","cy":"","date_created":"", "date_updated":""}
                                else:
                                    merged[item_id]["camera_type"] = row[2]
                            break
                    
                    for words in column_cam_subtype:
                        if words in users_input:
                            self.column_used= "Camera Subtype"
                            query= f"SELECT id, camera_id, camera_subtype FROM cctv_camera WHERE camera_id LIKE '%{self.description}%';"
                            self.cursor.execute(query)
                            result = self.cursor.fetchall()
                            for row in result:
                                item_id= row[0]
                                if item_id not in merged:
                                    merged[item_id] = {"id":row[0],"camera_id":row[1], "camera_type":"", "camera_subtype":row[2], "camera_ip_address":"","camera_port_no":"","camera_username":"","camera_password":"","camera_angle":"","camera_location":"","camera_brand":"","camera_model_no":"","camera_barcode":"","camera_status":"","camera_remarks":"","cx":"","cy":"","date_created":"", "date_updated":""}
                                else:
                                    merged[item_id]["camera_subtype"] = row[2]
                            break

                    for words in column_camip:
                        if words in users_input:
                            self.column_used= "Camera IP"
                            query= f"SELECT id, camera_id, camera_ip_address FROM cctv_camera WHERE camera_id LIKE '%{self.description}%';"
                            self.cursor.execute(query)
                            result = self.cursor.fetchall()
                            for row in result:
                                item_id= row[0]
                                if item_id not in merged:
                                    merged[item_id] = {"id":row[0],"camera_id":row[1], "camera_type":"", "camera_subtype":"", "camera_ip_address":row[2],"camera_port_no":"","camera_username":"","camera_password":"","camera_angle":"","camera_location":"","camera_brand":"","camera_model_no":"","camera_barcode":"","camera_status":"","camera_remarks":"","cx":"","cy":"","date_created":"", "date_updated":""}
                                else:
                                    merged[item_id]["camera_ip_address"] = row[2]
                            break
                    
                    for words in column_camport:
                        if words in users_input:
                            self.column_used= "Camera Port No."
                            query= f"SELECT id, camera_id, camera_port_no FROM cctv_camera WHERE camera_id LIKE '%{self.description}%';"
                            self.cursor.execute(query)
                            result = self.cursor.fetchall()
                            for row in result:
                                item_id= row[0]
                                if item_id not in merged:
                                    merged[item_id] = {"id":row[0],"camera_id":row[1], "camera_type":"", "camera_subtype":"", "camera_ip_address":"","camera_port_no":row[2],"camera_username":"","camera_password":"","camera_angle":"","camera_location":"","camera_brand":"","camera_model_no":"","camera_barcode":"","camera_status":"","camera_remarks":"","cx":"","cy":"","date_created":"", "date_updated":""}
                                else:
                                    merged[item_id]["camera_port_no"] = row[2]
                            break
                    
                    for words in column_camusername:
                        if words in users_input:
                            self.column_used= "Camera Username"
                            query= f"SELECT id, camera_id, camera_username FROM cctv_camera WHERE camera_id LIKE '%{self.description}%';"
                            self.cursor.execute(query)
                            result = self.cursor.fetchall()
                            for row in result:
                                item_id= row[0]
                                if item_id not in merged:
                                    merged[item_id] = {"id":row[0],"camera_id":row[1], "camera_type":"", "camera_subtype":"", "camera_ip_address":"","camera_port_no":"","camera_username":row[2],"camera_password":"","camera_angle":"","camera_location":"","camera_brand":"","camera_model_no":"","camera_barcode":"","camera_status":"","camera_remarks":"","cx":"","cy":"","date_created":"", "date_updated":""}
                                else:
                                    merged[item_id]["camera_username"] = row[2]
                            break
                    
                    for words in column_campassword:
                        if words in users_input:
                            self.column_used= "Camera Password"
                            query= f"SELECT id, camera_id, camera_password FROM cctv_camera WHERE camera_id LIKE '%{self.description}%';"
                            self.cursor.execute(query)
                            result = self.cursor.fetchall()
                            for row in result:
                                item_id= row[0]
                                if item_id not in merged:
                                    merged[item_id] = {"id":row[0],"camera_id":row[1], "camera_type":"", "camera_subtype":"", "camera_ip_address":"","camera_port_no":"","camera_username":"","camera_password":row[2],"camera_angle":"","camera_location":"","camera_brand":"","camera_model_no":"","camera_barcode":"","camera_status":"","camera_remarks":"","cx":"","cy":"","date_created":"", "date_updated":""}
                                else:
                                    merged[item_id]["camera_password"] = row[2]
                            break
                    
                    for words in column_camangnle:
                        if words in users_input:
                            self.column_used= "Camera Angle"
                            query= f"SELECT id, camera_id, camera_angle FROM cctv_camera WHERE camera_id LIKE '%{self.description}%';"
                            self.cursor.execute(query)
                            result = self.cursor.fetchall()
                            for row in result:
                                item_id= row[0]
                                if item_id not in merged:
                                    merged[item_id] = {"id":row[0],"camera_id":row[1], "camera_type":"", "camera_subtype":"", "camera_ip_address":"","camera_port_no":"","camera_username":"","camera_password":"","camera_angle":row[2],"camera_location":"","camera_brand":"","camera_model_no":"","camera_barcode":"","camera_status":"","camera_remarks":"","cx":"","cy":"","date_created":"", "date_updated":""}
                                else:
                                    merged[item_id]["camera_angle"] = row[2]
                            break

                    for words in column_camlocation:
                        if words in users_input:
                            self.column_used= "Camera Location"
                            query= f"SELECT id, camera_id, camera_location FROM cctv_camera WHERE camera_id LIKE '%{self.description}%';"
                            self.cursor.execute(query)
                            result = self.cursor.fetchall()
                            for row in result:
                                item_id= row[0]
                                if item_id not in merged:
                                    merged[item_id] = {"id":row[0],"camera_id":row[1], "camera_type":"", "camera_subtype":"", "camera_ip_address":"","camera_port_no":"","camera_username":"","camera_password":"","camera_angle":"","camera_location":row[2],"camera_brand":"","camera_model_no":"","camera_barcode":"","camera_status":"","camera_remarks":"","cx":"","cy":"","date_created":"", "date_updated":""}
                                else:
                                    merged[item_id]["camera_location"] = row[2]
                            break
                    
                    for words in column_cambrand:
                        if words in users_input:
                            self.column_used= "Camera Brand"
                            query= f"SELECT id, camera_id, camera_brand FROM cctv_camera WHERE camera_id LIKE '%{self.description}%';"
                            self.cursor.execute(query)
                            result = self.cursor.fetchall()
                            for row in result:
                                item_id= row[0]
                                if item_id not in merged:
                                    merged[item_id] = {"id":row[0],"camera_id":row[1], "camera_type":"", "camera_subtype":"", "camera_ip_address":"","camera_port_no":"","camera_username":"","camera_password":"","camera_angle":"","camera_location":"","camera_brand":row[2],"camera_model_no":"","camera_barcode":"","camera_status":"","camera_remarks":"","cx":"","cy":"","date_created":"", "date_updated":""}
                                else:
                                    merged[item_id]["camera_brand"] = row[2]
                            break
                    
                    for words in column_cammodel:
                        if words in users_input:
                            self.column_used= "Camera Model"
                            query= f"SELECT id, camera_id, camera_model_no FROM cctv_camera WHERE camera_id LIKE '%{self.description}%';"
                            self.cursor.execute(query)
                            result = self.cursor.fetchall()
                            for row in result:
                                item_id= row[0]
                                if item_id not in merged:
                                    merged[item_id] = {"id":row[0],"camera_id":row[1], "camera_type":"", "camera_subtype":"", "camera_ip_address":"","camera_port_no":"","camera_username":"","camera_password":"","camera_angle":"","camera_location":"","camera_brand":"","camera_model_no":row[2],"camera_barcode":"","camera_status":"","camera_remarks":"","cx":"","cy":"","date_created":"", "date_updated":""}
                                else:
                                    merged[item_id]["camera_model_no"] = row[2]
                            break
                    
                    for words in column_cambarcode:
                        if words in users_input:
                            self.column_used= "Camera Barcode"
                            query= f"SELECT id, camera_id, camera_barcode FROM cctv_camera WHERE camera_id LIKE '%{self.description}%';"
                            self.cursor.execute(query)
                            result = self.cursor.fetchall()
                            for row in result:
                                item_id= row[0]
                                if item_id not in merged:
                                    merged[item_id] = {"id":row[0],"camera_id":row[1], "camera_type":"", "camera_subtype":"", "camera_ip_address":"","camera_port_no":"","camera_username":"","camera_password":"","camera_angle":"","camera_location":"","camera_brand":"","camera_model_no":"","camera_barcode":row[2],"camera_status":"","camera_remarks":"","cx":"","cy":"","date_created":"", "date_updated":""}
                                else:
                                    merged[item_id]["camera_barcode"] = row[2]
                            break
                    
                    for words in column_camstatus:
                        if words in users_input:
                            self.column_used= "Camera Status"
                            query= f"SELECT id, camera_id, camera_status FROM cctv_camera WHERE camera_id LIKE '%{self.description}%';"
                            self.cursor.execute(query)
                            result = self.cursor.fetchall()
                            for row in result:
                                item_id= row[0]
                                if item_id not in merged:
                                    merged[item_id] = {"id":row[0],"camera_id":row[1], "camera_type":"", "camera_subtype":"", "camera_ip_address":"","camera_port_no":"","camera_username":"","camera_password":"","camera_angle":"","camera_location":"","camera_brand":"","camera_model_no":"","camera_barcode":"","camera_status":row[2],"camera_remarks":"","cx":"","cy":"","date_created":"", "date_updated":""}
                                else:
                                    merged[item_id]["camera_status"] = row[2]
                            break
                    
                    for words in column_camremarks:
                        if words in users_input:
                            self.column_used= "Camera Remarks"
                            query= f"SELECT id, camera_id, camera_remarks FROM cctv_camera WHERE camera_id LIKE '%{self.description}%';"
                            self.cursor.execute(query)
                            result = self.cursor.fetchall()
                            for row in result:
                                item_id= row[0]
                                if item_id not in merged:
                                    merged[item_id] = {"id":row[0],"camera_id":row[1], "camera_type":"", "camera_subtype":"", "camera_ip_address":"","camera_port_no":"","camera_username":"","camera_password":"","camera_angle":"","camera_location":"","camera_brand":"","camera_model_no":"","camera_barcode":"","camera_status":"","camera_remarks":row[2],"cx":"","cy":"","date_created":"", "date_updated":""}
                                else:
                                    merged[item_id]["camera_remarks"] = row[2]
                            break

                    for words in column_camx:
                        if words in users_input:
                            self.column_used= "Camera Coordinates X"
                            query= f"SELECT id, camera_id, cx FROM cctv_camera WHERE camera_id LIKE '%{self.description}%';"
                            self.cursor.execute(query)
                            result = self.cursor.fetchall()
                            for row in result:
                                item_id= row[0]
                                if item_id not in merged:
                                    merged[item_id] = {"id":row[0],"camera_id":row[1], "camera_type":"", "camera_subtype":"", "camera_ip_address":"","camera_port_no":"","camera_username":"","camera_password":"","camera_angle":"","camera_location":"","camera_brand":"","camera_model_no":"","camera_barcode":"","camera_status":"","camera_remarks":"","cx":row[2],"cy":"","date_created":"", "date_updated":""}
                                else:
                                    merged[item_id]["cx"] = row[2]
                            break
                    
                    for words in column_camy:
                        if words in users_input:
                            self.column_used= "Camera Coordinates Y"
                            query= f"SELECT id, camera_id, cy FROM cctv_camera WHERE camera_id LIKE '%{self.description}%';"
                            self.cursor.execute(query)
                            result = self.cursor.fetchall()
                            for row in result:
                                item_id= row[0]
                                if item_id not in merged:
                                    merged[item_id] = {"id":row[0],"camera_id":row[1], "camera_type":"", "camera_subtype":"", "camera_ip_address":"","camera_port_no":"","camera_username":"","camera_password":"","camera_angle":"","camera_location":"","camera_brand":"","camera_model_no":"","camera_barcode":"","camera_status":"","camera_remarks":"","cx":"","cy":row[2],"date_created":"", "date_updated":""}
                                else:
                                    merged[item_id]["cy"] = row[2]
                            break

                self.list_return_value= list(merged.values())
                return self.list_return_value
            else:
                self.list_return_value= list(merged.values())
                return self.list_return_value

        except Exception as e:
            self.list_return_value= list(merged.values())
            return self.list_return_value
    
    def forID(self, query):
        pos= query.index("id")
        getid= query[pos+2:]
        getid= int(getid[:-1].lstrip())
        if query.lower().startswith("id") and query.lower().endswith("a"): #equipment entry
            try:
                data= {"id":"","category":"","description":"","model_num":"","barcode":"","specification":"","status":"","remarks":"","date_created":"","date_updated":""}
                query= f"SELECT * FROM equipment_entry WHERE id={getid};"
                self.cursor.execute(query)
                result = self.cursor.fetchall()

                data["id"]= result[0][0]
                data["category"]= result[0][1+self.add_1]
                data["description"]= result[0][2+self.add_1]
                data["model_num"]= result[0][3+self.add_1]
                data["barcode"]= result[0][4+self.add_1]
                data["specification"]= result[0][5+self.add_1]
                data["status"]= result[0][6+self.add_1]
                data["remarks"]= result[0][7+self.add_1]
                data["date_created"]= result[0][8+self.add_1]
                data["date_updated"]= result[0][9+self.add_1]

                query= f"SELECT name FROM equipment WHERE id={int(data.get("category"))};"
                self.cursor.execute(query)
                result = self.cursor.fetchall()
                data["category"]= result[0][0]

                details= f"-----{data.get("description").upper()}-----\nID: {data.get("id")}a\nCategory: {data.get("category")}\nDescription: {data.get("description")}\nModel No.: {data.get("model_num")}\nBarcode: {data.get("barcode")}\nSpecifications: {data.get("specification")}\nStatus: {data.get("status")}\nRemarks: {data.get("remarks")}\nDate Created: {data.get("date_created")}\nDate Updated: {data.get("date_updated")}\n"
                return details, {}
            except Exception as e:
                # print(e)
                return "No result found!", {}

        elif query.lower().startswith("id") and query.lower().endswith("b"): #ip address
            try:
                data= {"id":"","network_name":"","ip_address":"","subnet":"","hostname":"","site":"","server":"","status":"","remarks":"","webport":"","username":"","password":"","date_created":"","date_updated":""}
                query= f"SELECT * FROM ip_address WHERE id={getid};"
                self.cursor.execute(query)
                result = self.cursor.fetchall()

                data["id"]= result[0][0]
                data["network_name"]= result[0][1]
                data["ip_address"]= result[0][2]
                data["subnet"]= result[0][3]
                data["hostname"]= result[0][4]
                data["site"]= result[0][5]
                data["server"]= result[0][6]
                data["status"]= result[0][7]
                data["remarks"]= result[0][8]
                data["webport"]= result[0][9]
                data["username"]= result[0][10]
                data["password"]= result[0][11]
                data["date_created"]= result[0][12]
                data["date_updated"]= result[0][13]

                query= f"SELECT name FROM ip_network WHERE id={int(data.get("network_name"))};"
                self.cursor.execute(query)
                result = self.cursor.fetchall()
                data["network_name"]= result[0][0]

                details= f"-----{data.get("hostname").upper()}-----\nID: {data.get("id")}b\nNetwork Name: {data.get("network_name")}\nIP Address: {data.get("ip_address")}\nSubnet: {data.get("subnet")}\nHostname: {data.get("hostname")}\nSite: {data.get("site")}\nServer: {data.get("server")}\nStatus: {data.get("status")}\nRemarks: {data.get("remarks")}\nWeb Management Port: {data.get("webport")}\nUsername: {data.get("username")}\nPassword: {data.get("password")}\nDate Created: {data.get("date_created")}\nDate Updated: {data.get("date_updated")}\n"
                return details, {}
            except Exception as e:
                return "No result found!", {}

        elif query.lower().startswith("id") and query.lower().endswith("c"): #ip network
            try:
                data= {"id":"","router_name":"","net_name":"","from":"","to":"","subnet":"","date_created":"","date_updated":""}
                query= f"SELECT * FROM ip_network WHERE id={getid};"
                self.cursor.execute(query)
                result = self.cursor.fetchall()

                data["id"]= result[0][0]
                data["router_name"]= result[0][1+self.add_1]
                data["net_name"]= result[0][2+self.add_1]
                data["from"]= result[0][3+self.add_1]
                data["to"]= result[0][4+self.add_1]
                data["subnet"]= result[0][5+self.add_1]
                data["date_created"]= result[0][6+self.add_1+self.add_1]
                data["date_updated"]= result[0][7+self.add_1+self.add_1]

                # if data["router_name"]  != "-":
                query= f"SELECT name FROM routers WHERE id={int(data.get("router_name"))};"
                self.cursor.execute(query)
                result = self.cursor.fetchall()
                data["router_name"]= result[0][0]

                details= f"-----{data.get("net_name").upper()}-----\nID: {data.get("id")}c\nRouter's Name: {data.get("router_name")}\nNetwork Name: {data.get("net_name")}\nDHCP Range: {data.get("from")} - {data.get("to")}\nSubnet: {data.get("subnet")}\nDate Created: {data.get("date_created")}\nDate Updated: {data.get("date_updated")}\n"
                return details, {}
            except Exception as e:
                return "No result found!", {}
                # print(e)
        elif query.lower().startswith("id") and query.lower().endswith("d"): # continue here
            try:
                data= {"id":"","isp_name":"","name":"","wan_ip":"","subnet":"","gateway":"","dns1":"","dns2":"","webport":"","date_created":"","date_updated":""}
                query= f"SELECT * FROM isp WHERE id={getid};"
                self.cursor.execute(query)
                result = self.cursor.fetchall()

                data["id"]= result[0][0]
                data["isp_name"]= result[0][1+self.add_1]
                data["name"]= result[0][2+self.add_1]
                data["wan_ip"]= result[0][3+self.add_1]
                data["subnet"]= result[0][4+self.add_1]
                data["gateway"]= result[0][5+self.add_1]
                data["dns1"]= result[0][6+self.add_1]
                data["dns2"]= result[0][7+self.add_1]
                data["webport"]= result[0][8+self.add_1]
                data["date_created"]= result[0][9+self.add_1]
                data["date_updated"]= result[0][10+self.add_1]

                if data['dns1'] == '-':
                    data['dns1']= "None"
                
                if data['dns2'] == '-':
                    data['dns2']= "None"
                

                details= f"-----{data.get("name").upper()}-----\nID: {data.get("id")}d\nISP Name: {data.get("isp_name")}\nName: {data.get("name")}\nWAN IP: {data.get("wan_ip")}\nSubnet: {data.get("subnet")}\nGateway: {data.get("gateway")}\nDNS 1: {data.get("dns1")}\nDNS 2: {data.get("dns2")}\nWeb Management Port: {data.get("webport")}\nDate Created: {data.get("date_created")}\nDate Updated: {data.get("date_updated")}"
                return details, {}
            except Exception as e:
                return "No result found!", {}
                # print(e)
        elif query.lower().startswith("id") and query.lower().endswith("e"):
            try:
                data= {"id":"","name":"","ip":"","subnet":"","wan1":"","wan2":"","active":"","date_created":"","date_updated":""}
                query= f"SELECT * FROM routers WHERE id={getid};"
                self.cursor.execute(query)
                result = self.cursor.fetchall()

                data["id"]= result[0][0]
                data["name"]= result[0][1+self.add_1]
                data["ip"]= result[0][2+self.add_1]
                data["subnet"]= result[0][3+self.add_1]
                data["wan1"]= result[0][4+self.add_1]
                data["wan2"]= result[0][5+self.add_1]
                data["active"]= result[0][6+self.add_1]
                data["date_created"]= result[0][7+self.add_1]
                data["date_updated"]= result[0][8+self.add_1]

                if data.get("wan1") != "-":
                    query= f"SELECT isp_name FROM isp WHERE id = {data.get("wan1")};"
                    self.cursor.execute(query)
                    result= self.cursor.fetchall()
                    data["wan1"]= result[0][0]
                else:
                    data["wan1"]= "None"

                if data.get("wan2") != "-":
                    query= f"SELECT isp_name FROM isp WHERE id = {data.get("wan2")};"
                    self.cursor.execute(query)
                    result= self.cursor.fetchall()
                    data["wan2"]= result[0][0]
                else:
                    data["wan2"]= "None"

                if data.get("active") != "-":
                    query= f"SELECT isp_name FROM isp WHERE id = {data.get("active")};"
                    self.cursor.execute(query)
                    result= self.cursor.fetchall()
                    data["active"]= result[0][0]
                else:
                    data["active"]= "None"

                details= f"-----{data.get("name").upper()}-----\nID: {data.get("id")}e\nName: {data.get("name")}\nIP Address: {data.get("ip")}\nSubnet: {data.get("subnet")}\nWAN 1: {data.get("wan1")}\nWAN 2: {data.get("wan2")}\nActive/Current ISP: {data.get("active")}\nDate Created: {data.get("date_created")}\nDate Updated: {data.get("date_updated")}"
                return details, {}
            
            except Exception as e:
                return "No result found!", {}
                # print(e)
        elif query.lower().startswith("id") and query.lower().endswith("f"):
            try:
                image_path= {}
                data= {"id":"","map_location":"", "floorplan":"", "remarks":"", "camera_size":"", "date_created":"", "date_updated":""}
                query= f"SELECT * FROM cctv_location WHERE id={getid};"
                self.cursor.execute(query)
                result = self.cursor.fetchall()

                data["id"]= result[0][0]
                data["map_location"]= result[0][1+self.add_1]
                data["floorplan"]= result[0][2+self.add_1]
                data["remarks"]= result[0][3+self.add_1]
                data["camera_size"]= result[0][4+self.add_1]
                data["date_created"]= result[0][5+self.add_1]
                data["date_updated"]= result[0][6+self.add_1]
            
                details= f"-----{data.get("map_location").upper()}-----\nID: {data.get("id")}f\nMap Location: {data.get("map_location")}\nRemarks: {data.get("remarks")}\nCamera Size: {data.get("camera_size")}\nDate Created: {data.get("date_created")}\nDate Updated: {data.get("date_updated")}"
                image_path[data.get("floorplan")]= details
                # print(image_path)
                return details, image_path
            
            except Exception as e:
                return "No result found!", {}
                # print(e)
        elif query.lower().startswith("id") and query.lower().endswith("g"):
            try:
                data= {"id":"","camera_id":"", "camera_type":"", "camera_subtype":"", "camera_ip_address":"","camera_port_no":"","camera_username":"","camera_password":"","camera_angle":"","camera_location":"","camera_brand":"","camera_model_no":"","camera_barcode":"","camera_status":"","camera_remarks":"","cx":"","cy":"","date_created":"", "date_updated":""}
                query= f"SELECT * FROM cctv_camera WHERE id={getid};"
                self.cursor.execute(query)
                result = self.cursor.fetchall()

                data["id"]= result[0][0]
                data["camera_id"]= result[0][1+self.add_1]
                data["camera_type"]= result[0][2+self.add_1]
                data["camera_subtype"]= result[0][3+self.add_1]
                data["camera_ip_address"]= result[0][4+self.add_1]
                data["camera_port_no"]= result[0][5+self.add_1]
                data["camera_username"]= result[0][6+self.add_1]
                data["camera_password"]= result[0][7+self.add_1]
                data["camera_angle"]= result[0][8+self.add_1]
                data["camera_location"]= result[0][9+self.add_1]
                data["camera_brand"]= result[0][10+self.add_1]
                data["camera_model_no"]= result[0][11+self.add_1]
                data["camera_barcode"]= result[0][12+self.add_1]
                data["camera_status"]= result[0][13+self.add_1]
                data["camera_remarks"]= result[0][14+self.add_1]
                data["cx"]= result[0][15+self.add_1]
                data["cy"]= result[0][16+self.add_1]
                data["date_created"]= result[0][17+self.add_1]
                data["date_updated"]= result[0][18+self.add_1]
            
                details= f"-----{data.get("camera_id").upper()}-----\nID: {data.get("id")}g\nCamera Type: {data.get("camera_type")}\nCamera Subtype: {data.get("camera_subtype")}\nCamera IP: {data.get("camera_ip_address")}\nCamera Port No.: {data.get("camera_port_no")}\nUsername: {data.get("camera_username")}\nPassword: {data.get("camera_password")}\nAngle: {data.get("camera_angle")}\nLocation: {data.get("camera_location")}\nBrand: {data.get("camera_brand")}\nModel No.: {data.get("camera_model_no")}\nBarcode: {data.get("camera_barcode")}\nStatus: {data.get("camera_status")}\nRemarks: {data.get("camera_remarks")}\nX-Coordinate: {data.get("cx")}\nY-Coordinate: {data.get("cy")}\nDate Created: {data.get("date_created")}\nDate Updated: {data.get("date_updated")}"
                return details, {}
            
            except Exception as e:
                return "No result found!", {}
                # print(e)
        
        else:
            return "Invalid Format ID", {}
        
if __name__ == "__main__":
    data= DATABASE()
    query= "wan of planning router"

    x= data.routerB(query)
    # print(x)

    