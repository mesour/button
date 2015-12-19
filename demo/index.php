<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="resources/css/bootstrap.min.css">

<!-- Optional theme -->
<link rel="stylesheet" href="resources/css/bootstrap-theme.min.css">

<!-- Latest compiled and minified JavaScript -->
<script src="resources/js/jquery.min.js"></script>
<script src="resources/js/bootstrap.min.js"></script>
<script src="resources/js/main.js"></script>

<?php

define('SRC_DIR', __DIR__ . '/../src/');

require_once __DIR__ . '/../vendor/autoload.php';

\Tracy\Debugger::enable(\Tracy\Debugger::DEVELOPMENT, __DIR__ . '/log');

require_once SRC_DIR . 'Mesour/UI/Button.php';

?>

<hr>

<div class="container">
    <h2>Without settings</h2>

    <div class="jumbotron">
        <?php

        $button = new \Mesour\UI\Button;

        $button->render();

        ?>
    </div>
</div>

<hr>

<div class="container">
    <h2>Set text</h2>

    <div class="jumbotron">
        <?php

        $button = new \Mesour\UI\Button;

        $button->setText('To mesour.com >>');

        $button->setAttribute('href', $button->link('http://mesour.com'))
            ->setAttribute('target', '_blank');

        $button->render();

        ?>
    </div>
</div>

<hr>

<div class="container">
    <h2>Set type, size and own class name</h2>

    <div class="jumbotron">
        <?php

        $button = new \Mesour\UI\Button;

        $button->setText('To mesour.com >>')
            ->setType('warning')
            ->setSize('btn-lg')
            ->setClassName('my-own-appended-class')
            ->setAttribute('href', $button->link('http://mesour.com'))
            ->setAttribute('target', '_blank');

        $button->render();

        ?>
    </div>
</div>

<hr>

<div class="container">
    <h2>Set disabled</h2>

    <div class="jumbotron">
        <?php

        $button = new \Mesour\UI\Button;

        $button->setText('To mesour.com >>')
            ->setType('warning')
            ->setSize('btn-lg')
            ->setClassName('my-own-appended-class')
            ->setAttribute('href', $button->link('http://mesour.com'))
            ->setAttribute('target', '_blank');

        $button->setDisabled();

        $button->render();

        ?>
    </div>
</div>

<hr>

<div class="container">
    <h2>Without classes</h2>

    <div class="jumbotron">
        <?php

        $button = new \Mesour\UI\Button();

        $button->setText('To mesour.com >>')
            ->setAttribute('class', FALSE)// set own class name or FALSE for unset
            ->setAttribute('href', $button->link('http://mesour.com'))
            ->setAttribute('target', '_blank');

        $button->render();

        ?>
    </div>
</div>

<hr>

<div class="container">
    <h2>Left and right icons</h2>

    <div class="jumbotron">
        <?php

        $button = new \Mesour\UI\Button();

        $button->setIcon('tree-deciduous');

        $button->setRightIcon('menu-right');

        $button->setText('MESOUR.COM')
            ->setType('danger')
            ->setSize('btn-lg')
            ->setAttribute('href', $button->link('http://mesour.com'))
            ->setAttribute('target', '_blank');

        $button->render();

        ?>
    </div>
</div>

<hr>

<div class="container">
    <h2>Only icon</h2>

    <div class="jumbotron">
        <?php

        $button = new \Mesour\UI\Button();

        $button->setIcon('pencil');

        $button->setType('primary')
            ->setSize('btn-lg')
            ->setAttribute('href', $button->link('http://mesour.com'))
            ->setAttribute('target', '_blank');

        $button->render();

        ?>
    </div>
</div>

<hr>

<div class="container">
    <h2>Using data parser via {key}</h2>

    <div class="jumbotron">
        <?php

        $button = new \Mesour\UI\Button();

        $button->setIcon('pencil');

        $button->setType('primary')
            ->setSize('btn-lg')
            ->setAttribute('id', 'user-{username}')
            ->setAttribute('href', $button->link('/edit-user/', ['id' => '{id}']))
            ->setAttribute('target', '_blank');

        $button->render([
            'id' => 25,
            'username' => 'root',
            'name' => 'Root'
        ]);

        ?>
    </div>
</div>

<hr>

<div class="container">
    <h2>Full Example</h2>

    <div class="jumbotron">
        <?php

        $button = new \Mesour\UI\Button();

        $button->setConfirm('Test confirm\' text?');

        $button->setAttribute('data-text', 'Test title', FALSE, TRUE); // TRUE = allow translates

        $button->setIcon('education');

        $button->setRightIcon('option-horizontal');

        $button->setSize('btn-lg');

        $button->setText('My text');

        $button->setClassName('my-test-2');

        $button->setAttribute('href', $button->link('/test/', ['id' => '{id}']));

        $button->onRender[] = function (\Mesour\UI\Button $button, $data) {
            if ($data['id'] <= 5) {
                $button->setDisabled();
                $button->setAttribute('data-xxx', 'ble');
                $button->getIconPrototype()
                    ->class('glyphicon glyphicon-menu-hamburger');
            } else {
                $button->setDisabled(FALSE);
            }

        };

        echo '<h4>Disabled id = 5</h4>';

        $button->render([
            'id' => 5
        ]);

        echo '<hr><h4>Enabled id = 25</h4>';

        $button->render([
            'id' => 25
        ]);

        ?>
    </div>
</div>

<hr>

<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>