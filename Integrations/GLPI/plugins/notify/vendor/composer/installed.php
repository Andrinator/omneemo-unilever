<?php return array(
    'root' => array(
        'pretty_version' => '1.0.0+no-version-set',
        'version' => '1.0.0.0',
        'type' => 'library',
        'install_path' => __DIR__ . '/../../',
        'aliases' => array(),
        'reference' => NULL,
        'name' => '__root__',
        'dev' => true,
    ),
    'versions' => array(
        '__root__' => array(
            'pretty_version' => '1.0.0+no-version-set',
            'version' => '1.0.0.0',
            'type' => 'library',
            'install_path' => __DIR__ . '/../../',
            'aliases' => array(),
            'reference' => NULL,
            'dev_requirement' => false,
        ),
        'atoum/atoum' => array(
            'pretty_version' => '4.1',
            'version' => '4.1.0.0',
            'type' => 'library',
            'install_path' => __DIR__ . '/../atoum/atoum',
            'aliases' => array(),
            'reference' => 'e866f3d4ad683c35757cd73fc6da3e3d5e563667',
            'dev_requirement' => true,
        ),
        'mageekguy/atoum' => array(
            'dev_requirement' => true,
            'replaced' => array(
                0 => '*',
            ),
        ),
    ),
);
