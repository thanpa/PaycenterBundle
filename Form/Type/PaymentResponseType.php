<?php

namespace Thanpa\PaycenterBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class PaymentResponseType
 * @package Thanpa\PaycenterBundle\Form
 */
class PaymentResponseType extends AbstractType
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
            ->add('supportReferenceId')
            ->add('resultCode')
            ->add('resultDescription')
            ->add('statusFlag')
            ->add('responseCode')
            ->add('responseDescription')
            ->add('languageCode')
            ->add('merchantReference')
            ->add('transactionDateTime')
            ->add('transactionId')
            ->add('cardType')
            ->add('packageNo')
            ->add('approvalCode')
            ->add('retrievalRef')
            ->add('authStatus')
            ->add('parameters')
            ->add('hashKey');
    }

    /**
     * Configure options
     *
     * @param OptionsResolver $resolver Resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'Thanpa\\PaycenterBundle\\Model\\PaymentResponse',
            'csrf_protection' => false,
        ]);
    }

    /**
     * Get form name (used in Symfony 2.*)
     *
     * @return string
     */
    public function getName()
    {
        return 'thanpa_paycenter_bundle_payment_response_type';
    }
}
