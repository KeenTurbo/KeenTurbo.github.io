<?php

namespace AppBundle\View\Pagerfanta;

use Pagerfanta\View\DefaultView;

/**
 * @author Wenming Tang <wenming@cshome.com>
 */
class SimpleView extends DefaultView
{
    /**
     * {@inheritdoc}
     */
    protected function createDefaultTemplate()
    {
        return new SimpleTemplate();
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'simple';
    }
}