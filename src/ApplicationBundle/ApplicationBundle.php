<?php

namespace ApplicationBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class ApplicationBundle extends Bundle
{
    public function getContainerExtension()
    {
        return new ApplicationExtension();
    }
}
