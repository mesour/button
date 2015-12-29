<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"
      integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">


<!-- Latest compiled and minified JavaScript -->
<script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"
        integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS"
        crossorigin="anonymous"></script>

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

        echo $button->render();

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

        echo $button->render();

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
            ->setAttribute('class', 'my-own-appended-class')
            ->setAttribute('href', $button->link('http://mesour.com'))
            ->setAttribute('target', '_blank');

        echo $button->render();

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
            ->setAttribute('class', 'my-own-appended-class')
            ->setAttribute('href', $button->link('http://mesour.com'))
            ->setAttribute('target', '_blank');

        $button->setDisabled();

        echo $button->render();

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
            ->setClassName('') // set own class name or FALSE for unset
            ->setAttribute('href', $button->link('http://mesour.com'))
            ->setAttribute('target', '_blank');

        echo $button->render();

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

        echo $button->render();

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

        echo $button->render();

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

        $button->setOption('data', [
            'id' => 25,
            'username' => 'root',
            'name' => 'Root'
        ]);
        echo $button->render();

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

        $button->setAttribute('class', 'my-test-2');

        $button->setAttribute('href', $button->link('/test/', ['id' => '{id}']));

        $button->onRender[] = function (\Mesour\UI\Button $button) {
            $data = $button->getOption('data');
            if ($data['id'] <= 5) {
                $button->setDisabled();
                $button->setAttribute('data-xxx', 'ble');
                $button->getLeftIcon()
                    ->setPrefix('fa fa-')
                    ->setType('bars');
            } else {
                $button->setDisabled(FALSE);
            }

        };

        echo '<h4>Disabled id = 5</h4>';

        $button->setOption('data', [
            'id' => 5
        ]);
        echo $button->render();

        echo '<hr><h4>Enabled id = 25</h4>';

        $button->setOption('data', [
            'id' => 25
        ]);
        echo $button->render();

        ?>
    </div>
</div>

<hr>

<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>