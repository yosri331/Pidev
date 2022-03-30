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
import entities.Reviews;
import java.util.Date;
/**
 *
 * @author hp
 */
public class ReviewForm extends Form{
    public ReviewForm(Form previous,Event t) {
          setTitle("Add a review");
        setLayout(BoxLayout.y());
        
        TextField tfName = new TextField("","Name");
        TextField tfDescription= new TextField("", "Description");
        TextField tfScore = new TextField("","Score");
        
        Button btnValider = new Button("Add Review");
        
        
        btnValider.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent evt) {
                if ((tfName.getText().length()==0)||(tfDescription.getText().length()==0)||(tfScore.getText().length()==0))
                    Dialog.show("Alert", "Please fill all the fields", new Command("OK"));
                else
                {
                    int score = Integer.parseInt(tfScore.getText().toString());
                      Reviews r = new Reviews(t.getUtilisateur_id(),t.getId(),score,tfName.getText().toString(),tfDescription.getText().toString(),true, new Date());
                        
                        
                        
                        if( ServiceEvents.getInstance().addReview(r, t))
                        {
                           Dialog.show("Success","Connection accepted",new Command("OK"));
                           Form f = new ViewEvent(previous,t);
                           f.show();
                        }else
                            Dialog.show("ERROR", "Server error", new Command("OK"));
                   
                    
                }
                
                
            }
        });
        
        addAll(tfName,tfDescription,tfScore,btnValider);
        getToolbar().addMaterialCommandToLeftBar("", FontImage.MATERIAL_ARROW_BACK, e-> previous.showBack());
                
    }
    }
    

