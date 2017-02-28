/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package managercantina;
import java.io.IOException;
import java.sql.*;

import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.SQLException;
import java.sql.Statement;
import javax.xml.parsers.ParserConfigurationException;
import org.xml.sax.SAXException;

/**
 *
 * @author Deviza
 */
public class DbConnection {
    
    Settings settings = LoadSettingsFromFile.get_settings();

   static final String JDBC_DRIVER = "com.mysql.jdbc.Driver";  
   protected static String DB_URL = "jdbc:mysql://localhost/db1";
   protected static String USER = "root";
   protected static String PASS = "";
   
   Connection conn = null;
   Statement stmt = null;
      
  DbConnection() throws ParserConfigurationException, SAXException, IOException
  {
      this.conn = null;
      this.stmt = null;
      
      try
      {
      Class.forName("com.mysql.jdbc.Driver");
      this.conn = DriverManager.getConnection(this.settings.getIp(),this.settings.getUsername(),this.settings.getPassword());
      this.stmt = this.conn.createStatement();
      }
      
      catch(SQLException | ClassNotFoundException se)
      {
      }    
  }
  
  public static ResultSet get_table() throws SQLException, ParserConfigurationException, SAXException, IOException
  {
      DbConnection db1 = new DbConnection();
      return db1.stmt.executeQuery("SELECT * FROM `comenzi_total`");
  }
  
  public  static void printTable(ResultSet rs) throws SQLException
  {
      while(rs.next())
      {
          int id  = rs.getInt("id");
         String email = rs.getString("mancare");
         int password = rs.getInt("cantitate");
         
         System.out.print("ID: " + id);
         System.out.print(", mancare: " + email);
         System.out.println(", cantitate: " + password);
      }
  }
  
  public static String getData() throws SQLException, ParserConfigurationException, SAXException, IOException
  {
      DbConnection db1 = new DbConnection();
      ResultSet rs=db1.stmt.executeQuery("SELECT table_comment FROM INFORMATION_SCHEMA.TABLES WHERE table_name = 'meniu' and table_schema = 'db1'");
      String s="";
      while(rs.next())
      {
          s=rs.getString("table_comment");
      }
      s=s.replace("\n", " ");

      return s;
  }
  
   
  public static boolean checkConnection() throws SQLException, ParserConfigurationException, SAXException, IOException
  {
      boolean isOK=false;
      try
      {
          DbConnection db1 = new DbConnection();
          try
          {
             db1.stmt.executeQuery("SELECT 1 FROM `users`");
              isOK=true;
          }
          catch (NullPointerException e)
                  {
                      System.out.println("Debug |class DbConn| method checkConnetion | execution query : eroare");
                  }
      }
      catch (IOException | ParserConfigurationException | SAXException e)
      {
          System.out.println("Debug |class DbConn| method checkConnetion | Object creation debug : eroare ");
      }
      return isOK;
  }
   
}
