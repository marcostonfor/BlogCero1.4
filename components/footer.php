<?php

class Footer implements ComponentsInterface
{
    public function pageComponents(): void
    {
    ?>
    <style>
        footer {
            display: block;
            width: 95%;
            margin: 2rem auto;
            background-color: #ffffee;            
            border: 0;
            border-radius: 0.3vw;
        }

        footer .subir {
            display: block;
            position: fixed;
            bottom: 0;
            left: 3rem !important;
        }

        footer figure {
            display: flex;
            justify-content: stretch;
            align-items: baseline;
            flex-direction: row-reverse;
            width: fit-content;
            margin: auto auto;
        }
    </style>  
    <footer>
        <figure>
            <figcaption>                
                <small>marcos </small><strong>@tonfor 
                    <img src="<?php echo BASE_URL ?>/components/img/viejoKubik.jpeg" alt="avatar" style="width: 10%;">
                </strong>
            </figcaption>
            <img src="<?php echo BASE_URL ?>/components/img/llegada.jpeg" alt="mi foto" style="width: 18%;">
        </figure>
            <small><a href="#subir">Subír</a></small>
    </footer>
    <?php
        }
}