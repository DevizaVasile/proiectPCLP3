/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package finalizarecomenzi;

import java.util.ArrayList;
import finalizarecomenzi.DbConnection.*;
import java.io.IOException;
import java.sql.SQLException;
import javax.xml.parsers.ParserConfigurationException;
import org.xml.sax.SAXException;

/**
 *
 * @author Deviza
 */
public class Comanda {
    
    ArrayList<ArrayList<String>> listOLists = new ArrayList<ArrayList<String>>();
    
    
    String email ;
    ArrayList<Integer> status = new ArrayList<Integer>() ;
    ArrayList<Integer> id = new  ArrayList<Integer>();
    ArrayList<String> comanda = new ArrayList<String>();
    ArrayList<String> ora_plasare = new ArrayList<String>();
    
    Comanda(String email) throws SQLException, ParserConfigurationException, SAXException, IOException
    {
        this.email=email;
        this.id=DbConnection.get_All_Id_By_Email(email);
        for(int x:id)
        {
            int temp = DbConnection.get_Status_By_Id(x);
            this.status.add(temp);
            this.ora_plasare.add(DbConnection.get_Date_By_ID(x));
            this.comanda=DbConnection.get_Comanda_By_Id(x);
            this.listOLists.add(comanda);
        }
    }
    
    public void representatnion()
    {
        
        System.out.println(this.email);
        System.out.println("Userul are: "+this.listOLists.size()+" comenzi.");
        System.out.println("**********");
        System.out.println("**********");
        int len=this.id.size();
        for(int i=0;i<len;i++)
        {
            System.out.println("ID comanda:"+id.get(i));
            System.out.println("Status comanda"+status.get(i));
            System.out.println("Ora plasare"+ora_plasare.get(i));
            for(int u=0;u<listOLists.get(i).size();u++)
            {
                System.out.println(listOLists.get(i).get(u));
            }
            System.out.println("*************");
        }
    }
    
    
}
