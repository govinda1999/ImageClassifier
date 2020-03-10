import flask
from flask import request, jsonify
import json
from subprocess import check_output
import tensorflow as tf
import tensorflow.keras.layers as Layers
import tensorflow.keras.activations as Actications
import tensorflow.keras.models as Models
import tensorflow.keras.optimizers as Optimizer
import tensorflow.keras.metrics as Metrics
import tensorflow.keras.utils as Utils
from keras.utils.vis_utils import model_to_dot
import os
import sys
import matplotlib.pyplot as plot
import cv2
import numpy as np
from sklearn.utils import shuffle
from sklearn.metrics import confusion_matrix as CM
from random import randint
from IPython.display import SVG
from keras.models import model_from_json
import matplotlib.gridspec as gridspec
from sklearn.model_selection import train_test_split


app = flask.Flask(__name__)
app.config["DEBUG"] = True
# Create an empty list for our results
results = []
#routes for single image
@app.route('/api/image', methods=['GET'])
def api_id():
    pippo=request.args.getlist('source')
    img1=jsonify(request.args)
    s=pippo[0]
    print("------------")
    test=s
    json_file = open("demo5.json","r") #path to model saved json file
    loaded_model_json = json_file.read()
    json_file.close()

    loaded_model = tf.keras.models.model_from_json(loaded_model_json,custom_objects=None)

    loaded_model.load_weights("model5.h5") #path to model saved h5 file

    loaded_model.compile(optimizer=Optimizer.Adam(lr=0.0001),loss='sparse_categorical_crossentropy',metrics=['accuracy'])
    img=cv2.imread("/opt/lampp/htdocs/frontend/upload/"+test)
    img=cv2.resize(img,(125,125))
    result=loaded_model.predict(np.array([img]))
    #file=open("test2.txt","w")
    result5={}
    result5['building']=str(result[0][0])
    result5['forest']=str(result[0][1])
    result5['glacier']=str(result[0][2])
    result5['mountain']=str(result[0][3])
    result5['sea']=str(result[0][4])
    result5['street']=str(result[0][5])
    with open("api.json","w") as file: #save result to api.json
        json.dump(result5,file)
    


    print("--------------")
    return "saurabh"                                           #json.load(open("api.json","a"))

#route to retrain model
@app.route('/api/retrain/',methods=['GET'])
def api_retrain():
    pipp1=request.args.getlist('learning_rate')
    pipp2=request.args.getlist('epoch')
    jsfile = request.args.getlist('json_file')
    hfile = request.args.getlist('h_file')


    #===========================

    class_names = ["buildings","forest","glacier","mountain","sea","street"]
    class_names_label = {class_name:i for i, class_name in enumerate(class_names)}
    nb_classes = len(class_names)
    IMAGE_SIZE = (125,125)
    Image=[]
    Labels=[]
    i=0
    print(class_names)
    for a in class_names:
        di = "/home/govinda/Desktop/retrain/"+a+"/"; #path to dataset for Buildings,forest ..etc
        for img_file in os.listdir(di):
            print(di)
            img = cv2.imread(di+img_file)
            img = cv2.resize(img,IMAGE_SIZE)
            Image.append(img)
            if a=="buildings":
                Labels.append(0)
            elif a=="forest":
                Labels.append(1)
            elif a=="glacier":
                Labels.append(2)
            elif a=="mountain":
                Labels.append(3)
            elif a=="sea":
                Labels.append(4)
            elif a=="street":
                Labels.append(5)
            else:
                pass
        

    Image,Labels = shuffle(Image,Labels,random_state=817328462)
    Images = np.array(Image)
    Labels = np.array(Labels)
    model = Models.Sequential()

    model.add(Layers.Conv2D(200,kernel_size=(3,3),activation='relu',input_shape=(125,125,3)))
    model.add(Layers.Conv2D(180,kernel_size=(3,3),activation='relu'))
    model.add(Layers.MaxPool2D(5,5))
    model.add(Layers.Conv2D(180,kernel_size=(3,3),activation='relu'))
    model.add(Layers.Conv2D(140,kernel_size=(3,3),activation='relu'))
    model.add(Layers.Conv2D(100,kernel_size=(3,3),activation='relu'))
    model.add(Layers.Conv2D(50,kernel_size=(3,3),activation='relu'))
    model.add(Layers.MaxPool2D(5,5))
    model.add(Layers.Flatten())
    model.add(Layers.Dense(180,activation='relu'))
    model.add(Layers.Dense(100,activation='relu'))
    model.add(Layers.Dense(50,activation='relu'))
    model.add(Layers.Dropout(rate=0.5))
    model.add(Layers.Dense(6,activation='softmax'))
    model.compile(optimizer=Optimizer.Adam(lr=float(pipp1[0])),loss='sparse_categorical_crossentropy',metrics=['accuracy'])
    model.summary()
    xtrain,xtest,ytrain,ytest = train_test_split(Images,Labels,test_size=0.2)
    trained = model.fit(xtrain,ytrain,epochs=int(pipp2[0]),validation_split=0.30)
    model_json = model.to_json()
    with open(jsfile[0],"w") as json_file: #save retrain model to json file
        json_file.write(model_json)

    model.save_weights(hfile[0]) #save weight to h5 file

    return "go"






    #===============================
    #print(learn)
    print(pipp1[0],pipp2[0])
    return "<h1>Hello Api</h1>"
#route to new training for new classifier
@app.route('/api/train',methods=['GET'])
def api_train():
    pippo=request.args.getlist('file1')
    s1=pippo[0]
    print(s1)
    pippo=request.args.getlist('file2')
    s2=pippo[0]
    print(s2)
    class_names = [s1,s2]
    class_names_label = {class_name:i for i, class_name in enumerate(class_names)}
    nb_classes = len(class_names)
    IMAGE_SIZE = (125,125)
    Image=[]
    Labels=[]
    i=0
    print(class_names)
    for a in class_names:
        di = "/home/govinda/Desktop/Image/"+a+"/"; #path to dataset of new classifier
        for img_file in os.listdir(di):
            print(di)
            img = cv2.imread(di+img_file)
            img = cv2.resize(img,IMAGE_SIZE)
            Image.append(img)
            if(i==0):
                Labels.append(0)
            else:
                Labels.append(1)
        i=i+1

    Image,Labels = shuffle(Image,Labels,random_state=817328462)
    Images = np.array(Image)
    Labels = np.array(Labels)
    model = Models.Sequential()

    model.add(Layers.Conv2D(200,kernel_size=(3,3),activation='relu',input_shape=(125,125,3)))
    model.add(Layers.Conv2D(180,kernel_size=(3,3),activation='relu'))
    model.add(Layers.MaxPool2D(5,5))
    model.add(Layers.Conv2D(180,kernel_size=(3,3),activation='relu'))
    model.add(Layers.Conv2D(140,kernel_size=(3,3),activation='relu'))
    model.add(Layers.Conv2D(100,kernel_size=(3,3),activation='relu'))
    model.add(Layers.Conv2D(50,kernel_size=(3,3),activation='relu'))
    model.add(Layers.MaxPool2D(5,5))
    model.add(Layers.Flatten())
    model.add(Layers.Dense(180,activation='relu'))
    model.add(Layers.Dense(100,activation='relu'))
    model.add(Layers.Dense(50,activation='relu'))
    model.add(Layers.Dropout(rate=0.5))
    model.add(Layers.Dense(6,activation='softmax'))
    model.compile(optimizer=Optimizer.Adam(lr=0.0001),loss='sparse_categorical_crossentropy',metrics=['accuracy'])
    model.summary()
    xtrain,xtest,ytrain,ytest = train_test_split(Images,Labels,test_size=0.2)
    trained = model.fit(xtrain,ytrain,epochs=1,validation_split=0.30)
    model.evaluate(xtest,ytest,verbose=1)
    model_json = model.to_json()
    with open("cat.json","w") as json_file: #save model to json file
        json_file.write(model_json)

    model.save_weights("cat.h5")#save model h5 file

    return "go"
#route to multiple image 
@app.route('/api/test',methods=['GET'])
def api_test():
    pippo=request.args.getlist('folder')
    s1=pippo[0]
    absolute = "/opt/lampp/htdocs/front/"+s1+"/"; #path to images
    Images=[]
    temp_img=[]
    for a in os.listdir(absolute):
        temp_img.append(a)
        img = cv2.imread(absolute+a)
        img = cv2.resize(img,(125,125))
        Images.append(img)
    json_file = open("demo5.json","r") #load model
    loaded_model_json = json_file.read()
    json_file.close()

    loaded_model = tf.keras.models.model_from_json(loaded_model_json,custom_objects=None)

    loaded_model.load_weights("model5.h5")

    loaded_model.compile(optimizer=Optimizer.Adam(lr=0.0001),loss='sparse_categorical_crossentropy',metrics=['accuracy'])
    
    Images= np.array(Images)
    iosum=loaded_model.predict(Images)
    
    dic={'building':[],'forest':[],'glacier':[],'mountain':[],'sea':[],'street':[],'name':[]}
    count=0
    for i in iosum:
        dic['building'].append(str(i[0]))
        dic['forest'].append(str(i[1]))
        dic['glacier'].append(str(i[2]))
        dic['mountain'].append(str(i[3]))
        dic['sea'].append(str(i[4]))
        dic['street'].append(str(i[5]))
        dic['name'].append(str(temp_img[count]))
        count+=1
    '''
    print(iosum)
    dic={}
    count=0
    for i in temp_img:
        dic[i]=iosum[count][:]
        count+=1

    '''
    with open("pred.json","w") as file: #save result to pred.json
        json.dump(dic,file)
    return "done"
app.run()
