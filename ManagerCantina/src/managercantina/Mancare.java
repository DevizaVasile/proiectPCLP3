/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package managercantina;

import javafx.beans.property.SimpleIntegerProperty;
import javafx.beans.property.SimpleStringProperty;

/**
 *
 * @author Deviza
 */
public class Mancare {
    
      private final String numeMancare;
      private final int cantitate;
      
      Mancare(String mancare , int cantitate)
      {
          this.numeMancare = mancare;
          this.cantitate   = cantitate;
      }

    public String getNumeMancare() {
        return numeMancare;
    }

    public int getCantitate() {
        return cantitate;
    }
      
      @Override
    public String toString(){
        String s="Tip:"+this.getNumeMancare()+" Cantitate:"+this.getCantitate();
        return s;
    } 
}
