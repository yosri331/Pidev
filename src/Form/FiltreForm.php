<?php
 namespace App\Form;

use App\Entity\Categorie;
use App\Entity\FiltreData;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FiltreForm extends AbstractType
{
 //méthode pour la construction de notre Form
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('q',TextType::class,[
                'label'=>false,
                //ce champs n'est pas obligatoire
                'required'=>false,
                'attr'=>['placeholder'=>'Rechercher']

            ])
            ->add('categories',EntityType::class,[
                'label'=>false,
                //ce champs n'est pas obligatoire
                'required'=>false,
                'class'=>Categorie::class,
                //pour avoir une liste de checkbox
                'expanded' => true,
                'multiple' => true

            ])
            ->add('min',NumberType::class,[
                'label'=>false,
                //ce champs n'est pas obligatoire
                'required'=>false,
                //attribut pour le placeholder
                'attr'=>['placeholder'=>'prix min']
            ])
            ->add('max',NumberType::class,[
                'label'=>false,
                //ce champs n'est pas obligatoire
                'required'=>false,
                //attribut pour le placeholder
                'attr'=>['placeholder'=>'prix max ']
            ])

            ->add('promo',CheckboxType::class,[
                'label'=>' En promotion',
                //ce champs n'est pas obligatoire
                'required'=>false,

            ])




        ;

    }


    //méthode pour configurer les différents options liée au se formulaire
    public function configureOptions(OptionsResolver $resolver)
    {
        //on utilise le resovler pour définir différent valeur par défaut
        $resolver->setDefaults([
            'data_class'=>FiltreData::class,
            //préciser la methode du formulaire
            'method' => 'GET',
            //désactiver la protection csrf
            'crsf_protection'=> false
        ]);
    }

    //méthode du prefixe si on utilise pas le formulaire sera afficher dans tableau

    public function getBlockPrefix()
    {
        return'';
    }

}
