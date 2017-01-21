/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package finalizarecomenzi;

import finalizarecomenzi.DbConnection.*;
import java.net.URL;
import java.sql.SQLException;
import java.util.ResourceBundle;
import java.util.logging.Level;
import java.util.logging.Logger;
import javafx.collections.FXCollections;
import javafx.collections.ObservableList;
import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.fxml.Initializable;
import javafx.scene.control.Alert;
import javafx.scene.control.Alert.AlertType;
import javafx.scene.control.Button;
import javafx.scene.control.Label;
import javafx.scene.control.ListView;
import javafx.scene.control.TableColumn;
import javafx.scene.control.TableView;
import javafx.scene.control.TextField;
import javafx.scene.input.MouseEvent;

/**
 *
 * @author Deviza
 */
public class FXMLDocumentController implements Initializable {
    
    private String email;
    private String selected;
    
    
    
    @FXML
    private Label user;
    @FXML
    private Label rezultat;
    @FXML
    private  TextField input = new TextField();
    @FXML
    private Label nr_comenzi_active = new Label();
    @FXML 
    private ListView<String> lista_view=new ListView<>();
    @FXML
    private ListView<String> lista_finala=new ListView<>();
    
   
   
   
   
    @FXML
    public void reset(ActionEvent event)
    {
        System.out.println("reset");
        this.email=null;
        this.selected=null;
        rezultat.setText("");
        user.setText("");
        nr_comenzi_active.setText("");
        lista_view.getItems().clear();
        lista_finala.getItems().clear();
        input.clear();
    }

    @FXML public void handleMouseClick(MouseEvent arg0) throws SQLException 
    {
        System.out.println("clicked on " + lista_view.getSelectionModel().getSelectedItem());
        String selected_item=lista_view.getSelectionModel().getSelectedItem();
        this.selected=selected_item;
        Comanda order = new Comanda(this.email);
        int index = order.ora_plasare.indexOf(selected_item);
        System.out.println(index);
        ObservableList<String> lista = FXCollections.observableArrayList();
        for(String s:order.listOLists.get(index))
        {
            lista.add(s);
        }
        lista_finala.setItems(lista);
            
    }
    
    @FXML
    private void findUser(ActionEvent event) throws SQLException {
        ObservableList<String> lista = FXCollections.observableArrayList();
        if(input.getText() != null && !input.getText().isEmpty())
        {
            if(DbConnection.check_If_Email_Exists(input.getText())==true)
            {
                user.setText(input.getText());
                Comanda order = new Comanda(input.getText());
                this.email=input.getText();
                if(order.id.size()>0)
                {
                    String s="";
                    Integer size=order.id.size();
                    s=size.toString();
                    nr_comenzi_active.setText(s);
                    
                    
                    Integer nr_obiecte_in_lista=order.ora_plasare.size();
                    for(String iterr:order.ora_plasare)
                    {
                        lista.add(iterr);
                        
                    }
                    System.out.println(lista.size());
                    lista_view.setItems(lista);
                    
                    
                    
                }
                else
                {
                   nr_comenzi_active.setText("Nu exista comenzi"); 
                   lista.clear();
                   lista_view.getItems().clear();
                }
            } 
            else 
            {
                Alert alert = new Alert(AlertType.INFORMATION);
                alert.setTitle("Information Dialog");
                alert.setHeaderText(null);
                alert.setContentText("User inexistent");
                alert.showAndWait();
                input.clear();
                user.setText("");
                lista.clear();
                nr_comenzi_active.setText("");
                lista_view.getItems().clear();
            }
        }
        else
        {
            Alert alert = new Alert(AlertType.INFORMATION);
            alert.setTitle("Information Dialog");
            alert.setHeaderText(null);
            alert.setContentText("Introduceti date valide");
            alert.showAndWait();
            input.clear();
            user.setText("");
            lista_view.getItems().clear();
            lista.clear();
            nr_comenzi_active.setText("");
        }
        
    }
    
    @FXML 
    public void finalizareComanda(ActionEvent event) throws SQLException
    {
      String selected=this.selected;
      Comanda order = new Comanda(this.email);
      int index = order.ora_plasare.indexOf(selected);
      int good = DbConnection.update_Status(order.id.get(index));
      if(good==1)
      {
          rezultat.setText("Succes");
          lista_view.getItems().remove(index);
          lista_finala.getItems().clear();
      }
      else
      {
          rezultat.setText("Eroare");
      }
    }
    
    @Override
    public void initialize(URL url, ResourceBundle rb) {
     
        try {
            Comanda x = new Comanda("cococo@gmail.com");
            x.representatnion();
        } catch (SQLException ex) {
            Logger.getLogger(FXMLDocumentController.class.getName()).log(Level.SEVERE, null, ex);
        }
        
        ObservableList<String> lista = FXCollections.observableArrayList();
        lista.clear();
        
        
    }    
    
}
