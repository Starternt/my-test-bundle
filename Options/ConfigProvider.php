<?php

namespace Starternh\MyTestBundle\Options;

use Symfony\Component\HttpFoundation\Request;

class ConfigProvider
{
    protected $paths;
    protected $defaults;

    public function __construct(array $paths, array $defaults = [])
    {
        $this->defaults = $defaults;
        $this->paths = $paths;
    }

    public function getOptions(Request $request): array
    {
        $uri = $request->getPathInfo() ?: '/';
        foreach ($this->paths as $pathRegexp => $options) {
            if (preg_match('{'.$pathRegexp.'}i', $uri)) {
                $options = array_merge($this->defaults, $options);

                // skip if the host is not matching
                if (count($options['hosts']) > 0) {
                    foreach ($options['hosts'] as $hostRegexp) {
                        if (preg_match('{'.$hostRegexp.'}i', $request->getHost())) {
                            return $options;
                        }
                    }

                    continue;
                }

                return $options;
            }
        }

        return $this->defaults;
    }
}
