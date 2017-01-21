/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package finalizarecomenzi;

import java.sql.*;

import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.SQLException;
import java.sql.Statement;
import java.util.ArrayList;
import java.util.regex.Matcher;
import java.util.regex.Pattern;

/**
 *
 * @author Deviza
 */
public class DbConnection {

   static final String JDBC_DRIVER = "com.mysql.jdbc.Driver";  
   protected static String DB_URL = "jdbc:mysql://localhost/db1";
   protected static String USER = "root";
   protected static String PASS = "";

   
   Connection conn = null;
   Statement stmt = null;
      
  DbConnection()
  {
      this.conn = null;
      this.stmt = null;
      
      try
      {
      //STEP 2: Register JDBC driver
      Class.forName("com.mysql.jdbc.Driver");

      //STEP 3: Open a connection
      this.conn = DriverManager.getConnection(DB_URL,USER,PASS);

      //STEP 4: Execute a query
      this.stmt = this.conn.createStatement();
      }
      
      catch(SQLException se)
      {
      //Handle errors for JDBC
      se.printStackTrace();
      }
      
      catch(Exception e)
      {
      //Handle errors for Class.forName
      e.printStackTrace();
      }    
  }
  
  public  ResultSet get_table() throws SQLException
  {
      DbConnection db1 = new DbConnection();
      return db1.stmt.executeQuery("SELECT * FROM `comenzi_personale`");
  }
  
   static void printTable(ResultSet rs) throws SQLException
  {
      while(rs.next())
      {
         int id  = rs.getInt("id");
         String email = rs.getString("email");
         int status = rs.getInt("status");
         String comanda = rs.getString("comanda");
         
         System.out.print("ID: " + id);
         System.out.print(", email: " + email);
         System.out.print(", status: " + status);
         System.out.println(", comanda:" + comanda);
         
      }
  }
  
   static public ArrayList<Integer> get_All_Id_By_Email(String email) throws SQLException
  {
      DbConnection db1 = new DbConnection();
      ArrayList<Integer> lista=new ArrayList<Integer>();
      ResultSet rs=db1.stmt.executeQuery("SELECT `id` FROM `comenzi_personale` WHERE   `status` = 0 AND `email` = '"+email+"'");
      while(rs.next())
      {
         lista.add(rs.getInt("id"));
      }
      return (lista);
  }
  
  static public ArrayList<String> get_Comanda_By_Id(int id) throws SQLException
  {
     DbConnection db1 = new DbConnection();
     ArrayList<String> lista=new ArrayList<String>();
     ResultSet rs=db1.stmt.executeQuery("SELECT `comanda` FROM `comenzi_personale` WHERE `id` ="+id);
     String temp="";
     int counter=0;
     while(rs.next())
     {
         temp=rs.getString("comanda");
     }
     
     temp=temp.replace("&&&", "&");
     int index = temp.indexOf("&");
        while (index >= 0) 
        {
            index = temp.indexOf("&", index + 1);
            counter=counter+1;
        }
        
    ArrayList<Integer> positions = new ArrayList<Integer>();
    index = temp.indexOf("&");
    while(index >= 0) 
        {
            positions.add(index);
            index = temp.indexOf("&", index + 1);
        }
    
    lista.add(temp.substring(0, positions.get(0)-1));
    for(int x=0;x<positions.size()-1;x++)
    {
        lista.add(temp.substring(positions.get(x),positions.get(x+1)));
    }
         
    for (int i = 0; i < lista.size(); i++)
    {
        lista.set(i, lista.get(i).replace("&", ""));
        lista.set(i, lista.get(i).trim());
   
    }  
     return lista;
  }
   
  static public int get_Status_By_Id(int id) throws SQLException
  { 
      DbConnection db1 = new DbConnection();
      ResultSet rs= db1.stmt.executeQuery("SELECT `status` FROM `comenzi_personale` WHERE `id` ="+id);
      int temp=0;
      while(rs.next())
      {
          temp = rs.getInt("status");
      }
       return temp;    
  }
  
  static public int update_Status(int id) throws SQLException
  {
      DbConnection db1 = new DbConnection();
       int rs = db1.stmt.executeUpdate("UPDATE `comenzi_personale` SET `status` = '1' WHERE `comenzi_personale`.`id`="+id);
       return rs;
      
  }
   
  public static boolean check_If_Email_Exists(String email) throws SQLException
  {
       DbConnection db1 = new DbConnection();
       ResultSet rs = db1.stmt.executeQuery("SELECT * FROM `comenzi_personale` WHERE `email` = '"+email+"'");
       int counter=0;
       while(rs.next())
       {
           counter=counter+1;
       }
       if (counter==0)
           {return false;}
       else
           {return true;}
  
  }

  static public String get_Date_By_ID(int id) throws SQLException
  {
     DbConnection db1 = new DbConnection();
      ResultSet rs= db1.stmt.executeQuery("SELECT `ora_plasare` FROM `comenzi_personale` WHERE `id` ="+id);
      String temp="";
      while(rs.next())
      {
          temp = rs.getString("ora_plasare");
      }
       return temp;  
  }


}

