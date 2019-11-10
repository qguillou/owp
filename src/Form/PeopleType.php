<?php
// src/Form/TagType.php
namespace App\Form;

use App\Entity\People;
use App\Entity\Base;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Repository\BaseRepository;

class PeopleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('base', EntityType::class, [
                'required' => false,
                'class' => Base::class,
                'query_builder' => function (BaseRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.club', 'ASC');
                },
                'group_by' => 'club'
            ])
        ;

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => People::class,
        ]);
    }
}
