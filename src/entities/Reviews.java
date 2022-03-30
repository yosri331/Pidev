/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Classes/Class.java to edit this template
 */
package entities;
import java.text.DateFormat;
import java.text.SimpleDateFormat;
import java.util.Date;
/**
 *
 * @author hp
 */
public class Reviews {
    private int id,utilisateur_id,event_id,score;
    private String nom,description;
    private Boolean hidden;
    private Date date;

    public Reviews() {
    }

    public Reviews(int utilisateur_id, int event_id, int score, String nom, String description, Boolean hidden, Date date) {
        this.utilisateur_id = utilisateur_id;
        this.event_id = event_id;
        this.score = score;
        this.nom = nom;
        this.description = description;
        this.hidden = hidden;
        this.date = date;
    }

    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }

    public int getUtilisateur_id() {
        return utilisateur_id;
    }

    public void setUtilisateur_id(int utilisateur_id) {
        this.utilisateur_id = utilisateur_id;
    }

    public int getEvent_id() {
        return event_id;
    }

    public void setEvent_id(int event_id) {
        this.event_id = event_id;
    }

    public int getScore() {
        return score;
    }

    public void setScore(int score) {
        this.score = score;
    }

    public String getNom() {
        return nom;
    }

    public void setNom(String nom) {
        this.nom = nom;
    }

    public String getDescription() {
        return description;
    }

    public void setDescription(String description) {
        this.description = description;
    }

    public Boolean getHidden() {
        return hidden;
    }

    public void setHidden(Boolean hidden) {
        this.hidden = hidden;
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
        return  "id=" + id + ", utilisateur_id=" + utilisateur_id + ", event_id=" + event_id + ", score=" + score + ", nom=" + nom + ", description=" + description + ", hidden=" + hidden + ", date=" + date + '}';
    }
    
}
