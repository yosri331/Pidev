/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Classes/Class.java to edit this template
 */
package entities;
import java.util.Date;
import java.text.DateFormat;  
import java.text.SimpleDateFormat;  
/**
 *
 * @author hp
 */
public class Event {
    private int id;
    private int utilisateur_id;
    private String nom,descrption,participants,imagefile;
    private Date date;

    public Event(int id, String nom, String descrption, String participants, String imagefile, Date date,int utilisateur_id) {
        this.id = id;
        this.nom = nom;
        this.descrption = descrption;
        this.participants = participants;
        this.imagefile = imagefile;
        this.date = date;
        this.utilisateur_id=utilisateur_id;
    }

    public int getUtilisateur_id() {
        return utilisateur_id;
    }

    public void setUtilisateur_id(int utilisateur_id) {
        this.utilisateur_id = utilisateur_id;
    }

  

    public Event() {
    }

    public Event(String nom, String descrption, String participants, String imagefile, Date date,int utilisateur_id) {
        this.nom = nom;
        this.descrption = descrption;
        this.participants = participants;
        this.imagefile = imagefile;
        this.date = date;
        this.utilisateur_id = utilisateur_id;
        
    }

    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }

    public String getNom() {
        return nom;
    }

    public void setNom(String nom) {
        this.nom = nom;
    }

    public String getDescrption() {
        return descrption;
    }

    public void setDescrption(String descrption) {
        this.descrption = descrption;
    }

    public String getParticipants() {
        return participants;
    }

    public void setParticipants(String participants) {
        this.participants = participants;
    }

    public String getImagefile() {
        return imagefile;
    }

    public void setImagefile(String imagefile) {
        this.imagefile = imagefile;
    }

    public Date getDate() {
        return date;
    }

    public void setDate(Date date) {
        this.date = date;
    }
    public String DateToString(){
        
        DateFormat dateformat=new SimpleDateFormat("yyyy-mm-dd");
        String date =dateformat.format(this.date) ;
        return date;
        
    }

    @Override
    public String toString() {
        String date ;
        date=DateToString();
        return "Event{" + "id=" + id + ", nom=" + nom + ", descrption=" + descrption + ", participants=" + participants + ", imagefile=" + imagefile + ", date=" + date + "utilisateur_id:"+utilisateur_id+ '}';
    }


    
}
