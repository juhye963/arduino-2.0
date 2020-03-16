import serial
import pymysql
#from time import localtime,strftime

getdata = serial.Serial('COM7',9600)

def getAverage():
    num = 60
    i=0
    result=0
    while(i<num):
        temp=getdata.readline()
        temp=temp[:-2]
        temp=eval(temp)
        i=i+1
        result+=temp
    result=result/float(num)
    return temp

while True:
    data=0
    data=getAverage()
    db = pymysql.connect(host='18.188.26.108', port=3306, user='sample', passwd='password', db='arduino', charset='utf8')
## 18.220.44.81 운영서버
## localhost

    cursor = db.cursor()
    sql = "INSERT INTO temp_tb(temp) values("+str(data)+");"
    cursor.execute(sql)
    db.commit()




#https://miscel.tistory.com/6