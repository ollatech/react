<?php
namespace Olla\React\Bundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

final class OllaReactBundle extends Bundle
{
	public function build(ContainerBuilder $container)
	{
		parent::build($container);
	}
}
