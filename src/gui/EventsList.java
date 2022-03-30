/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Classes/Class.java to edit this template
 */
package gui;
import com.codename1.components.SpanLabel;
import com.codename1.ui.FontImage;
import com.codename1.ui.Button;
import com.codename1.ui.Command;
import com.codename1.ui.Form;
import com.codename1.ui.Container;
import com.codename1.ui.Dialog;
import com.codename1.ui.Display;
import com.codename1.ui.Font;
import com.codename1.ui.Image;
import services.ServiceEvents;
import static java.util.Collections.list;
import com.codename1.ui.layouts.BoxLayout;
import com.codename1.ui.Label;
import com.codename1.ui.events.ActionEvent;
import com.codename1.ui.events.ActionListener;
import com.codename1.ui.plaf.Style;
import java.util.*;
import entities.Event;
import java.io.IOException;

/**
 *
 * @author hp
 */
public class EventsList extends Form {
    
    
    Form current;
    public Container addItem(Event u,Form previous){
        
        Container cnt = new Container(BoxLayout.y());
        Label lbnom=new Label(u.getNom());
        Label lbdesc=new Label(u.getDescrption());
        Label btnparticipants=new Label(u.getParticipants());
         Label lbdate=new Label(u.getDate().toString());
         Label lbimage = new Label();
         System.out.println("/"+u.getImagefile());
         try{
         Image img = Image.createImage("/"+u.getImagefile());
         Image resizedimg = img.scaledWidth(Math.round(Display.getInstance().getDisplayWidth()/2));
         lbimage.setIcon(resizedimg);
         }
         catch(IOException e){
             
         }
        
        Button btnView= new Button("View Event");
        cnt.addAll(lbimage,lbnom,lbdesc,btnparticipants,lbdate,btnView);
        Container cnt2 = new Container(BoxLayout.x());
        cnt2.addAll(cnt);
        btnView.addActionListener(e-> new ViewEvent(previous,u).show()) ;
        return cnt2;
    }
     public EventsList(Form previous) {
         Font fnt = Font.createTrueTypeFont("native:MainLight", "native:MainLight").
                derive(Display.getInstance().convertToPixels(5, true), Font.STYLE_PLAIN);
        Style s = new Style(0xffff33, 0, fnt, (byte) 0);
        setTitle("List Events");
        ArrayList<Event> list=ServiceEvents.getInstance().getAllEvents();
        SpanLabel sp = new SpanLabel();
        add(sp);
        for(Event E : list){
            add(addItem(E,previous));
             
        }
        getToolbar().addMaterialCommandToLeftBar("", FontImage.MATERIAL_ARROW_BACK, e -> previous.showBack());
        
        
    }
}
