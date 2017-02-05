/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package managercantina;


/**
 *
 * @author Deviza
 */
public class Settings {
    private final String ip;
    private final String database;
    private final String username;
    private final String password;
    
    Settings(String ip , String database, String username , String password){
        this.ip=ip;
        this.database=database;
        this.username=username;
        this.password=password;
    }

    public String getIp() {
        return ip;
    }

    public String getDatabase() {
        return database;
    }

    public String getUsername() {
        return username;
    }

    public String getPassword() {
        return password;
    }
   
}
