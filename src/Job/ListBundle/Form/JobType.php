<?php

namespace Job\ListBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class JobType extends AbstractType
{
    public function buildForm(FormBuilderInterface $formBuilderInterface, array $options)
    {
        $formBuilderInterface
            ->add('title', 'text', array(
                'label' => 'Enter your title: ',
            ))
            ->add('description', 'textarea', array(
                'label' => 'Enter description: ',
            ))
            ->add('Save', 'submit', array(
                'label' => 'Add Job'
            ));
    }

    public function setDefaultOptions(OptionsResolverInterface $optionsResolverInterface)
    {
        $optionsResolverInterface->setDefaults(array(
            'data_class' => 'Job\ListBundle\Entity\Job'
        ));
    }

    public function getName()
    {
        return 'job';
    }
}
