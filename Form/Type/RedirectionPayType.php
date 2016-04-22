<?php

namespace Thanpa\PaycenterBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class RedirectionPayType
 * @package Thanpa\PaycenterBundle\Form
 */
class RedirectionPayType extends AbstractType
{
    /**
     * Build form
     *
     * @param FormBuilderInterface $builder Builder
     * @param array                $options Options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('AcquirerId', HiddenType::class)
            ->add('MerchantId', HiddenType::class)
            ->add('PosId', HiddenType::class)
            ->add('User', HiddenType::class)
            ->add('LanguageCode', HiddenType::class)
            ->add('MerchantReference', HiddenType::class)
            ->add('ParamBackLink', HiddenType::class);
    }

    /**
     * Configure options
     *
     * @param OptionsResolver $resolver Resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'Thanpa\\PaycenterBundle\\Model\\RedirectionPay',
            'csrf_protection' => false,
        ]);
    }

    /**
     * This method is removed in Symfony 3.0. Since this bundle is Symfony2 compatible
     * we need to declare it here.
     *
     * @return string
     */
    public function getName()
    {
        return 'thanpa_paycenter_bundle_redirection_pay_type';
    }
}
