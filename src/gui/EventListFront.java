/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Classes/Class.java to edit this template
 */
package gui;
import com.codename1.components.SpanLabel;
import com.codename1.ui.FontImage;
import com.codename1.ui.Form;
import services.ServiceEvents;
/**
 *
 * @author hp
 */
public class EventListFront extends Form {
    
    
     public EventListFront(Form previous) {
        setTitle("List Events");
        
        SpanLabel sp = new SpanLabel();
        sp.setText(ServiceEvents.getInstance().getAllEvents().toString());
        add(sp);
        getToolbar().addMaterialCommandToLeftBar("", FontImage.MATERIAL_ARROW_BACK, e -> previous.showBack());
    } 
    
}
