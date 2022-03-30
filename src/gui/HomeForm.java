
/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Classes/Class.java to edit this template
 */
package gui;
import com.codename1.ui.Button;
import com.codename1.ui.Form;
import com.codename1.ui.Label;
import com.codename1.ui.layouts.BoxLayout;
import com.codename1.ui.util.Resources;
import demo_gui.ActivateForm;
/**
 *
 * @author hp
 */
public class HomeForm extends Form{
Form current;
    public HomeForm()  {
        current=this; //Back 
        setTitle("Home");
        setLayout(BoxLayout.y());
        
        
        add(new Label("Choose an option"));
        Button btnAddTask = new Button("Add Task");
        Button btnListTasks = new Button("List Tasks");
        Button btnAddEvent = new Button("Add Event");
        Button btnListEvents = new Button("List Events");
        Button btnNewForm = new Button("Other demo");
        
        btnListEvents.addActionListener(e-> new EventsList(current).show());
        btnAddEvent.addActionListener(e-> new EventForm(current).show());
       
        addAll(btnListEvents,btnAddEvent,btnNewForm);
        
        
    } 
    
}
