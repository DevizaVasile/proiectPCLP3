from bs4 import BeautifulSoup
import mechanicalsoup
import time
import pymysql
import re
import xml.etree.cElementTree as et

#datele bazei de date
url="localhost"
username="root"
password=""
database='db1'



#datele de logare pentru a extrage meniul
URL = 'http://portal.unitbv.ro/Default.aspx?tabid=36&ctl=Login&returnurl=%2fDefault.aspx%3ftabid%3d36'
LOGIN = 'gabriel.tutu@student.unitbv.ro'
PASSWORD = 'ALIN9(Ee'

#functie ce cauta tabelelu
def get_table_soup():
    try:
        browser = mechanicalsoup.Browser()
        login_page = browser.get(URL)
        login_form = login_page.soup.select("form")[0]
        login_form.find(attrs={"name": "dnn$ctr$Login$Login_LDAP$lgAGSISPortalLogin$UserName"})['value'] = LOGIN       #atentie neaparat value , pierdut 2 ore debug :(
        login_form.find(attrs={"name": "dnn$ctr$Login$Login_LDAP$lgAGSISPortalLogin$Password"})['value'] = PASSWORD    #same shit
        response = browser.submit(login_form, login_page.url)
        print("Submit responese status:" + str(response.status_code))

        page = browser.get('http://portal.unitbv.ro/Default.aspx?tabid=276')
        page2 = page.text
        page3=BeautifulSoup(page2, "html.parser")
        BSpage = BeautifulSoup(browser.get('http://portal.unitbv.ro/Default.aspx?tabid=276').text, 'html.parser')
        return BSpage
    except:
        print("abort")
        return None


#functie interna returneaza 4 liste si patru titluri a fiecarei liste
def find_table_4vectors(soup):
    row1=[]
    row2=[]
    row3=[]
    row4=[]

    table=soup.find(attrs={"style":"border-collapse: collapse; border: medium none; width: 573px;"})
    table=BeautifulSoup(str(table) , 'html.parser')
    print(str(type(table)))

    rows1=table.findAll(attrs={"style":"border-style: solid solid solid none; border-width: 1pt 1pt 1pt medium; padding: 0in 5.4pt; width: 33.6364px;"})
    rows2=table.findAll(attrs={"style":"border-style: solid solid solid none; border-width: 1pt 1pt 1pt medium; padding: 0in 5.4pt; width: 336px;"})
    rows3=table.findAll(attrs={"style":"border-style: solid solid solid none; border-width: 1pt 1pt 1pt medium; padding: 0in 5.4pt; width: 91px;"})
    rows4=table.findAll(attrs={"style":"border-style: solid solid solid none; border-width: 1pt 1pt 1pt medium; padding: 0in 5.4pt; width: 30px;"})
    for x in rows1:
        row=BeautifulSoup(str(x) , 'html.parser')
        row=row.text
        re.sub(r'[^\x00-\x7F]+','', row)
        row.encode('ascii', 'ignore')
        row = row.replace(u'\xa0', u'')
        row = row.replace(u'\0x2',u'')
        row.rstrip('\t\r\n\r\s')
        row.strip()
        row1.append(row)
    for x in rows2:
        row=BeautifulSoup(str(x) , 'html.parser')
        row=row.text
        re.sub(r'[^\x00-\x7F]+','', row)
        row.encode('ascii', 'ignore')
        row = row.replace(u'\xa0', u'')
        row = row.replace(u'\0x2',u'')
        row.rstrip('\t\r\n\r\s')
        row.strip()
        row2.append(row)
    for x in rows3:
        row=BeautifulSoup(str(x) , 'html.parser')
        row=row.text
        re.sub(r'[^\x00-\x7F]+','', row)
        row.encode('ascii', 'ignore')
        row = row.replace(u'\xa0', u'')
        row = row.replace(u'\0x2',u'')
        row.strip()
        row.rstrip('\t\r\n\r\s')
        row3.append(row)
    for x in rows4:
        row=BeautifulSoup(str(x) , 'html.parser')
        row=row.text
        re.sub(r'[^\x00-\x7F]+','', row)
        row.encode('ascii', 'ignore')
        row = row.replace(u'\xa0', u'')
        row = row.replace(u'\0x2',u'')
        row.strip()
        row.rstrip('\t\r\n\r\s')
        row4.append(row)
    if(len(row1)==0 or len(row2)==0 or len(row3)==0 or len(row4)==0):
        print("**********")
        print("Atentie , necesita recalibrare ")
        print("**********")
        return None
    else:
        title1=row1[0]
        title2=row2[0]
        title3=row3[0]
        title4=row4[0]
        row1=row1[1:]
        row2=row2[1:]
        row3=row3[1:]
        row4=row4[1:]
    return row1,row2,row3,row4,title1,title2,title3,title4

#muie neimplementata
def find_table_vector(soup):
    row1=[]
    row2=[]
    row3=[]
    row4=[]
    final=[]
    table=soup.find(attrs={"style":"border-collapse: collapse; border: medium none; width: 573px;"})
    table=BeautifulSoup(str(table) , 'html.parser')
    print(str(type(table)))
    rows1=table.findAll(attrs={"style":"border-style: solid solid solid none; border-width: 1pt 1pt 1pt medium; padding: 0in 5.4pt; width: 37px;"})
    rows2=table.findAll(attrs={"style":"border-style: solid solid solid none; border-width: 1pt 1pt 1pt medium; padding: 0in 5.4pt; width: 336px;"})
    rows3=table.findAll(attrs={"style":"border-style: solid solid solid none; border-width: 1pt 1pt 1pt medium; padding: 0in 5.4pt; width: 91px;"})
    rows4=table.findAll(attrs={"style":"border-style: solid solid solid none; border-width: 1pt 1pt 1pt medium; padding: 0in 5.4pt; width: 30px;"})
    for x in rows1:
        row=BeautifulSoup(str(x) , 'html.parser')
        row1.append(row.text)
    for x in rows2:
        row=BeautifulSoup(str(x) , 'html.parser')
        row2.append(row.text)
    for x in rows3:
        row=BeautifulSoup(str(x) , 'html.parser')
        row3.append(row.text)
    for x in rows4:
        row=BeautifulSoup(str(x) , 'html.parser')
        row4.append(row.text)

    if len(row1)==len(row2)==len(row3)==len(row4):
        print("succes")
        for x in range(1,len(row1)):
            final.append(row1[x].strip()+"   "+row2[x].strip()+"   "+ row3[x].strip()+"   "+row4[x].strip()+" lei")
    return final


#returneaza data din table ca string
def get_date(soup):
    table = soup.find(attrs={"style": "font-size: 18px;"})
    table = BeautifulSoup(str(table), 'html.parser')
    table = table.text.strip()
    table = table.replace("\n", "")
    return table

#salveaza meniul ca o lista html
def save_as_html_list(table, date):
    now = time.strftime("%Y.%m.%d .. %H.%M")
    file = open("Meniu V1.7 " + str(now) + ".html", 'w')
    file.write("<h3>"+date+"</h3> <br>")
    file.write("\n")
    file.write('<ul  class="list-group" style="list-style-type:none">')
    for x in table:
        file.write('<li class="list-group-item">' + x + '</li>')
        file.write("\n")
    file.write("</ul>")
    file.close()
    
#salveaza meniul ca un table cu 4 coloane (1 nr de ordine , 2 nume mancare , 3 cantitate  , 4 pret)
def safe_as_html_table(a1,a2,a3,a4,t1,t2,t3,t4,date):
    now = time.strftime("%Y.%m.%d .. %H.%M")
    file = open("meniu.html", 'w')
    file.write("<h3>"+date+"</h3> <br>")
    file.write("\n")
    file.write('<table class="table" id="menu_table">')
    for x in range(0,len(a1)):
        file.write("<tr> <td>"+a1[x].strip()+"</td> <td>"+a2[x].strip()+"</td><td>"+a3[x].strip()+"</td><td>"+a4[x].strip()+"</td></tr>")
        file.write("\n")
    file.write("</table>")
    file.close()
    
#salveaza menul ca un fisier xml   
def save_as_xml(a1,a2,a3,a4,t1,t2,t3,t4,t):
    now = time.strftime("%Y.%m.%d .. %H.%M")
    file = open("meniu.xml",'w')
    file.write('<?xml version="1.0" encoding="UTF-8"?>')
    file.write("\n")
    file.write("<meniu>")
    file.write("\n")
    for x in range(0,len(a1)):
        file.write("<mancare>")
        file.write("\n")
        file.write("   <nume>"+a2[x].strip()+"</nume>")
        file.write("\n")
        file.write("   <cantitate>"+a3[x].strip()+"</cantitate>")
        file.write("\n")
        file.write("   <pret>"+a4[x].strip()+"</pret>")
        file.write("\n")
        file.write("</mancare>")
        file.write("\n")
    file.write("</meniu>")
    


#functia data sterge toate inregistrarile din tabelul meniului si introduce altele din ziua respectiva

def send_to_database(date):
    nume=[]
    pret=[]
    cantitate=[]
    with open('meniu.xml', 'r') as content_file:
        content = content_file.read()
        print(str(type(content))+"type of read file")
        tree=et.fromstring(content)
        for el in tree.findall('mancare'):
            for ch in el.findall('nume'):
                nume.append(ch.text)
            for ch in el.findall('cantitate'):
                cantitate.append(ch.text)
            for ch in el.findall('pret'):
                nmbr=ch.text
                nmbr=nmbr.replace(',','.')
                pret.append(nmbr)
    if(len(nume)==len(pret) and len(nume)==len(cantitate)):
        conn = pymysql.connect(host=url, port=3306, user=username, passwd=password, db=database)
        cur = conn.cursor()
        cur.execute("DELETE FROM meniu")
        conn.commit()
        cur.execute("ALTER TABLE meniu COMMENT '%s';" %(date))
        conn.commit()
        for x in range(0,len(nume)):
            cur.execute("INSERT INTO `meniu` (`id`, `mancare`, `pret`, `gramaj`) VALUES (NULL , '%s' , '%s' , '%s');" %(nume[x],pret[x],cantitate[x]))
        conn.commit()
        conn.close()
 

def send_porduct_list_to_database(date):
    nume=[]
 
    with open('meniu.xml', 'r') as content_file:
        content = content_file.read()
        print(str(type(content))+"type of read file")
        tree=et.fromstring(content)
        for el in tree.findall('mancare'):
            for ch in el.findall('nume'):
                nume.append(ch.text)
    conn = pymysql.connect(host=url, port=3306, user=username, passwd=password, db=database)
    cur = conn.cursor()
    cur.execute("DELETE FROM comenzi_total")
    conn.commit()
    cur.execute("ALTER TABLE comenzi_total COMMENT '%s';" %(date))
    conn.commit()
    for x in range(0,len(nume)):
        cur.execute("INSERT INTO `comenzi_total` (`id`, `mancare`,  `cantitate`) VALUES (NULL , '%s' , '0');" %(nume[x]))
    conn.commit()
    conn.close()
        
def drop_comenzi_personale():
    conn = pymysql.connect(host=url, port=3306, user=username, passwd=password, db=database)
    cur = conn.cursor()
    cur.execute("DELETE FROM comenzi_personale")
    conn.commit()
    conn.close()
    




x=get_table_soup()
a1,a2,a3,a4,t1,t2,t3,t4=find_table_4vectors(x)
t=get_date(x)
safe_as_html_table(a1,a2,a3,a4,t1,t2,t3,t4,t)
save_as_xml(a1,a2,a3,a4,t1,t2,t3,t4,t)
#ATENTIE!!! cand sunt executate ultimile 2 functii sunt sterse toate datele din tabelul meniu si tabelul comenzi totale , apoi se introduc date noi 
send_to_database(t);
send_porduct_list_to_database(t)
drop_comenzi_personale()

