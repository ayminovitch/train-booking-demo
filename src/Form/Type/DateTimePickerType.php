<?php

/*
 * (c) Aymen Hammami <hello@aymen-hammami.com> 
 *
 * Github: https://github.com/ayminovitch
 * Created at: Mon Jan 16 2023
 */


namespace App\Form\Type;

use App\Utils\MomentFormatConverter;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;
use function Symfony\Component\String\u;


class DateTimePickerType extends AbstractType
{
    public function __construct(
        private MomentFormatConverter $formatConverter
    ) {
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options): void
    {
        $view->vars['attr']['data-date-format'] = $this->formatConverter->convert($options['format']);
        $view->vars['attr']['data-date-locale'] = u(\Locale::getDefault())->replace('_', '-')->lower();
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'widget' => 'single_text',
            'html5' => false,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getParent(): ?string
    {
        return DateTimeType::class;
    }
}
