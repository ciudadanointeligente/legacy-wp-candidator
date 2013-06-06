<div class="candideit-candidatos">
    <h4>Candidatos</h4>
    <ul>
        <?php
        foreach ($aCandidatos as $c) {
            ?>
            <li>
                <img src="<?php echo ($c->photo) ? $c->photo : 'http://placehold.it/200x200' ?>">
                
                <h3><?php echo $c->name ?></h3>
                <?php
                
                foreach ($c->personal_data as $p) {
                    ?>
                    <p><?php echo $p->label ?> : <?php echo $p->value ?></p>
                    <?php
                }
                
                ?>
            </li>
            <?php
        }
        
        ?>
    </ul>
</div>