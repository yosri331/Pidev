/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Classes/Class.java to edit this template
 */
package gui;
import com.codename1.components.SpanLabel;
import com.codename1.ui.Button;
import com.codename1.ui.Command;
import com.codename1.ui.Dialog;
import com.codename1.ui.FontImage;
import com.codename1.ui.Form;
import com.codename1.ui.TextField;
import com.codename1.ui.events.ActionEvent;
import com.codename1.ui.events.ActionListener;
import com.codename1.ui.layouts.BoxLayout;
import services.ServiceEvents;
import entities.Event;
import java.text.SimpleDateFormat;
import java.util.Date;
import java.text.ParseException;

/**
 *
 * @author hp
 */
public class EventForm extends Form{

    public EventForm(Form previous) {
        
        {
        
        setTitle("Add a new task");
        setLayout(BoxLayout.y());
        
        TextField tfName = new TextField("","EventName");
        TextField tfDescription= new TextField("", "Description");
        TextField tfDate = new TextField("","Date");
        TextField tfParticipants= new TextField("", "liste participants");
        TextField tfOrganiseur= new TextField("","Organiseur");
        TextField tfImagefile= new TextField("", "ImageFile");
        TextField tfUserId=new TextField("","userId");
        Button btnValider = new Button("Add Event");
        
        
        btnValider.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent evt) {
                if ((tfName.getText().length()==0)||(tfDescription.getText().length()==0)||(tfDate.getText().length()==0)||(tfParticipants.getText().length()==0)||(tfImagefile.getText().length()==0))
                    Dialog.show("Alert", "Please fill all the fields", new Command("OK"));
                else
                {
                    try {
                        Date todate=new SimpleDateFormat("yyyy-MM-dd").parse(tfDate.getText().toString());
                        int user_id =Integer.parseInt(tfUserId.getText().toString());
                     
                        Event t= new Event(tfName.getText().toString(),tfDescription.getText().toString(),tfParticipants.getText().toString(),tfImagefile.getText().toString(),todate,user_id);
                        System.out.print(t.toString());
                        
                        
                        if( ServiceEvents.getInstance().addEvent(t))
                        {
                           Dialog.show("Success","Connection accepted",new Command("OK"));
                        }else
                            Dialog.show("ERROR", "Server error", new Command("OK"));
                    } catch (ParseException e) {
                        Dialog.show("ERROR", "Status must be a number", new Command("OK"));
                    }
                    
                }
                
                
            }
        });
        
        addAll(tfName,tfDescription,tfDate,tfImagefile,tfParticipants,tfOrganiseur,tfUserId,btnValider);
        getToolbar().addMaterialCommandToLeftBar("", FontImage.MATERIAL_ARROW_BACK, e-> previous.showBack());
                
    }
    }
    
}
