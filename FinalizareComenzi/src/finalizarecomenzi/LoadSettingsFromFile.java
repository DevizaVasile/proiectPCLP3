/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package finalizarecomenzi;

import org.w3c.dom.*;
import javax.xml.parsers.*;
import java.io.*;
import org.xml.sax.SAXException;

/**
 *
 * @author Deviza
 */
public class LoadSettingsFromFile 
{
     protected static  Settings get_settings() throws ParserConfigurationException, SAXException, IOException
     {
          String file = System.getProperty("user.dir");
          file=file+"\\settings.xml";
          File f = new File(file);
          DocumentBuilderFactory dbFactory = DocumentBuilderFactory.newInstance();
          DocumentBuilder dBuilder = dbFactory.newDocumentBuilder();
          Document doc = dBuilder.parse(file);
          doc.getDocumentElement().normalize();
          NodeList nList = doc.getElementsByTagName("Settings");
          Node nNode = nList.item(0);
          Element eElement = (Element) nNode;
          Settings settings = 
                  new Settings
        (
                eElement.getElementsByTagName("ip").item(0).getTextContent(),
                eElement.getElementsByTagName("db_name").item(0).getTextContent(),
                eElement.getElementsByTagName("username").item(0).getTextContent(),
                eElement.getElementsByTagName("password").item(0).getTextContent()
        );
          return settings;   
     }

  
}