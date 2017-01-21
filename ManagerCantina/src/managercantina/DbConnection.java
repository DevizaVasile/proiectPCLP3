/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package managercantina;
import java.sql.*;

import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.SQLException;
import java.sql.Statement;

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
      System.out.println("Connecting to database...");
      this.conn = DriverManager.getConnection(DB_URL,USER,PASS);

      //STEP 4: Execute a query
      //Aici e toata magia
      System.out.println("Creating statement...");
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
      return db1.stmt.executeQuery("SELECT * FROM `comenzi_total`");
  }
  
  public void printTable(ResultSet rs) throws SQLException
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
  
  public String getData() throws SQLException
  {
      DbConnection db1 = new DbConnection();
      ResultSet rs=db1.stmt.executeQuery("SELECT table_comment FROM INFORMATION_SCHEMA.TABLES WHERE table_name = 'meniu' and table_schema = 'db1'");
      String s="";
      while(rs.next())
      {
          s=rs.getString("table_comment");
      }
      System.out.println(s.indexOf("DATA"));
      s=s.replace("\n", " ");

      return s;
  }
  
   
   
   
}
