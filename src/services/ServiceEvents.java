/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Classes/Class.java to edit this template
 */
package services;

import com.codename1.io.CharArrayReader;
import com.codename1.io.ConnectionRequest;
import com.codename1.io.JSONParser;
import com.codename1.io.NetworkEvent;
import com.codename1.io.NetworkManager;
import com.codename1.ui.events.ActionListener;
import java.io.IOException;
import java.util.ArrayList;
import java.util.List;
import java.util.Map;
import utils.Statics;
import entities.Event;
import java.util.Date;
import java.text.SimpleDateFormat;
import entities.Reviews;
import java.text.ParseException;
/**
 *
 * @author hp
 */
public class ServiceEvents {
    public ArrayList<Event> events;
    public ArrayList<Reviews> reviews;
    
    public static ServiceEvents instance=null;
    public boolean resultOK;
    private ConnectionRequest req;
    public ServiceEvents() {
         req = new ConnectionRequest();
    }

    public static ServiceEvents getInstance() {
        if (instance == null) {
            instance = new ServiceEvents();
        }
        return instance;
    }
    public boolean ParticiperEvent(int id,String nom){
        String url=Statics.BASE_URL+"participerjson/"+id+"/"+nom;
        req.setUrl(url);
        req.addResponseListener(new ActionListener<NetworkEvent>() {
            @Override
            public void actionPerformed(NetworkEvent evt) {
                resultOK = req.getResponseCode() == 200; //Code HTTP 200 OK
                req.removeResponseListener(this);
            }
        });
        NetworkManager.getInstance().addToQueueAndWait(req);
        return resultOK;
    }
    public boolean addReview(Reviews r,Event t){
        String url = Statics.BASE_URL+"addreviewjson/" +t.getId();
        req.setUrl(url);
        req.addArgument("nom",r.getNom());
        
        req.addArgument("description",r.getDescription());
        req.addArgument("score",r.getScore()+"");
        req.addArgument("date",r.getDate()+"");
        req.addResponseListener(new ActionListener<NetworkEvent>() {
            @Override
            public void actionPerformed(NetworkEvent evt) {
                resultOK = req.getResponseCode() == 200; //Code HTTP 200 OK
                req.removeResponseListener(this);
            }
        });
        NetworkManager.getInstance().addToQueueAndWait(req);
        return resultOK;
    }
    public boolean addEvent(Event t) {
        System.out.println(t);
        System.out.println("********");
        
       String url = Statics.BASE_URL +"jsonAddEvent/new";
       String pattern="yyyy-MM-dd";
       SimpleDateFormat FormatDate=new SimpleDateFormat(pattern);
       String date=FormatDate.format(t.getDate());
       
       System.out.print("Date!!:"+t.getDate());
       System.out.print("FormattedDate!!:"+date+"end");
      
       req.setUrl(url);
       
       req.addArgument("nom", t.getNom());
       req.addArgument("description", t.getDescrption()+"");
       req.addArgument("date", date+"");
      
        req.addArgument("participants", t.getParticipants()+"");
        req.addArgument("image", t.getImagefile()+"");
        req.addArgument("organiseur",t.getUtilisateur_id()+"");
        String regeturl=req.getUrl();
        
       req.addResponseListener(new ActionListener<NetworkEvent>() {
            @Override
            public void actionPerformed(NetworkEvent evt) {
                resultOK = req.getResponseCode() == 200; //Code HTTP 200 OK
                req.removeResponseListener(this);
            }
        });
        NetworkManager.getInstance().addToQueueAndWait(req);
        return resultOK;
    }
    
    
    
    
    public boolean UpdateEvent(Event t){
        String url = Statics.BASE_URL +"jsonUpdateEvent/"+t.getId();
        return resultOK;
    }
    
    
    

    public ArrayList<Event> parseEvents(String jsonText){
        try {
            events=new ArrayList<>();
            JSONParser j = new JSONParser();
            Map<String,Object> tasksListJson = 
               j.parseJSON(new CharArrayReader(jsonText.toCharArray()));
            
            List<Map<String,Object>> list = (List<Map<String,Object>>)tasksListJson.get("root");
            for(Map<String,Object> obj : list){
                Event t = new Event();
                float id = Float.parseFloat(obj.get("id").toString());
                float user_id =Float.parseFloat(obj.get("utilisateur_id").toString());
                t.setId((int)id);
                t.setUtilisateur_id((int)user_id);
                t.setDescrption(obj.get("description").toString());
                String date=obj.get("date").toString();
                
                try{
                 Date todate=new SimpleDateFormat("yyyy-mm-dd").parse(date);
                 t.setDate(todate);
                }
                catch(ParseException e){
                    e.printStackTrace();
                }
                if(t.getDate()==null){
                    t.setDate(new Date());
                }
                if(obj.get("image")==null){
                    t.setImagefile("null");
                }
                else{
                    t.setImagefile((obj.get("image").toString()));
                }
                if(obj.get("participants")==null){
                    t.setParticipants("null");
                }
                else{
                   t.setParticipants((obj.get("participants").toString())); 
                }
                
                if (obj.get("nom")==null)
                t.setNom("null");
                else
                    t.setNom(obj.get("nom").toString());
                events.add(t);
              
            }
            
            
        } catch (IOException ex) {
            
        }
        return events;
    }
    public ArrayList<Reviews> parseReviews(String jsonText){
        try {
            reviews =new ArrayList<>();
            JSONParser j = new JSONParser();
            Map<String,Object> tasksListJson = 
               j.parseJSON(new CharArrayReader(jsonText.toCharArray()));
            
            List<Map<String,Object>> list = (List<Map<String,Object>>)tasksListJson.get("root");
            for(Map<String,Object> obj : list){
                Reviews t = new Reviews();
                float id = Float.parseFloat(obj.get("id").toString());
                float user_id =Float.parseFloat(obj.get("utilisateur_id").toString());
                float score = Float.parseFloat(obj.get("score").toString());
                t.setScore((int)score);
                t.setId((int)id);
                t.setUtilisateur_id((int)user_id);
                t.setDescription(obj.get("description").toString());
                String date=obj.get("date").toString();
                
                try{
                 Date todate=new SimpleDateFormat("yyyy-mm-dd").parse(date);
                 t.setDate(todate);
                }
                catch(ParseException e){
                    e.printStackTrace();
                }
                if(t.getDate()==null){
                    t.setDate(new Date());
                }
                if(obj.get("hidden")==null){
                    t.setHidden(null);
                } 
                else t.setHidden(true);
                
                if (obj.get("nom")==null)
                t.setNom("null");
                else
                    t.setNom(obj.get("nom").toString());
                reviews.add(t);
              
            }
            
            
        } catch (IOException ex) {
            
        }
        return reviews;
    }
    public ArrayList<Event> getAllEvents(){
        //String url = Statics.BASE_URL+"/tasks/";
        String url = Statics.BASE_URL+"AllEvents/";
        req.setUrl(url);
        req.setPost(false);
        req.addResponseListener(new ActionListener<NetworkEvent>() {
            @Override
            public void actionPerformed(NetworkEvent evt) {
                events = parseEvents(new String(req.getResponseData()));
                req.removeResponseListener(this);
            }
        });
        NetworkManager.getInstance().addToQueueAndWait(req);
        return events;
    }
    public ArrayList<Reviews> getAllReviewsByEventId(int id){
        String url = Statics.BASE_URL+"ReviewByEventId/"+id;
        req.setUrl(url);
        req.setPost(false);
        req.addResponseListener(new ActionListener<NetworkEvent>() {
            @Override
            public void actionPerformed(NetworkEvent evt) {
                reviews = parseReviews(new String(req.getResponseData()));
                req.removeResponseListener(this);
            }
        });
        NetworkManager.getInstance().addToQueueAndWait(req);
        return reviews;
    }
}
