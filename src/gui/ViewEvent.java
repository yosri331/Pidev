/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Classes/Class.java to edit this template
 */
package gui;
import com.codename1.ui.Button;

import com.codename1.components.SpanLabel;
import com.codename1.ui.Command;
import com.codename1.ui.Dialog;
import com.codename1.ui.Container;
import com.codename1.ui.FontImage;
import com.codename1.ui.Form;
import com.codename1.ui.TextField;
import com.codename1.ui.events.ActionEvent;
import com.codename1.ui.events.ActionListener;
import com.codename1.ui.layouts.BoxLayout;
import entities.Event;
import services.ServiceEvents;
import com.codename1.ui.CheckBox;
import com.codename1.ui.ComboBox;
import com.codename1.ui.Image;
import com.codename1.ui.Label;
import com.codename1.ui.RadioButton;
import com.codename1.ui.TextArea;
import java.util.ArrayList;
import entities.Reviews;
import java.io.IOException;

/**
 *
 * @author hp
 */
public class ViewEvent extends Form {
    Form current;
    public Container addItem(Reviews r){
        current=this;
        Container cnt = new Container(BoxLayout.y());
         Label lbnom=new Label(r.getNom());
        Label lbdesc=new Label(r.getDescription());
        Label lbscore=new Label(r.getScore()+"");
        Label lbdate = new Label(r.getDate().toString());
        
        cnt.addAll(lbnom,lbdesc,lbscore,lbdate);
        Container cnt2=new Container(BoxLayout.x());
        cnt2.addAll(cnt);
        return cnt2;
        
    }
    

    public ViewEvent(Form previous,Event u) {
        
        
        
        getToolbar().addMaterialCommandToLeftBar("", FontImage.MATERIAL_ARROW_BACK, e -> previous.showBack());
        setTitle("View Event");
        setLayout(BoxLayout.y());
         Button btnAdd= new Button("Add Review");
         Button btnParticiper= new Button("Participer");
         Dialog d = new Dialog("Add Review");
         
         
         btnAdd.addActionListener(e-> new ReviewForm(previous,u).show());
         
        Label lbnom=new Label(u.getNom());
        Label lbdesc=new Label(u.getDescrption());
        Label btnparticipants=new Label(u.getParticipants());
         Label lbdate=new Label(u.getDate().toString());
         Label lbimage = new Label();
         System.out.println("/"+u.getImagefile());
         try{
         Image img = Image.createImage("/"+u.getImagefile());
         lbimage.setIcon(img);
         }
         catch(IOException e){
             
         }
         ArrayList<Reviews> list=ServiceEvents.getInstance().getAllReviewsByEventId(u.getId());
         SpanLabel sp = new SpanLabel();
         addAll(lbimage,lbnom,lbdesc,btnparticipants,lbdate,btnAdd);
         add(sp);
         for(Reviews R : list){
             add(addItem(R));
              
         }
         
         

       
    }
    
    
    
}
