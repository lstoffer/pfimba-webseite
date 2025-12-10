</div>

<footer id="footer">
  

    <?php 
        $contact = $site->footerContact()->toStructure()->first();
        $additionalLinks = $site->footerLinks()->toStructure();
        $socialMediaLinks = $site->socialMediaLinks()->toStructure();
    ?>

    <div class="footer col1">
      <div class="one-col">
            <h3>Kontakt</h3>
            <p>
                <?= $contact->name() ?> <br>
                <?= $contact->strasse() ?> <br>
                <?= $contact->wohnort() ?>
                <a class="email" href="mailto:<?= $contact->email() ?>"><?= $contact->email() ?></a>
            </p>
      </div>
    </div>

    <div class="footer col2">
        <div class="one-col">
            <h3>Weitere Links</h3>
            <p>
                <?php foreach ($additionalLinks as $additionalLink): ?>
                    <a class="website" href="<?= $additionalLink->link()->toPage()->url() ?>"><?= $additionalLink->label() ?></a><br>
                <?php endforeach ?>
            </p>
        </div>
    </div>

    <div class="footer col3">
        <div class="one-col">
            <h3>Social Media</h3>
            <p>
                <?php foreach ($socialMediaLinks as $socialMediaLink): ?>
                    <a class="website" href="<?= $socialMediaLink->url() ?>" target="_blank" rel="noopener"><?= $socialMediaLink->label() ?></a><br>
                <?php endforeach ?>
            </p>
        </div>
    </div>

    <div class="footer-logos">
        <a href="https://pfadi.swiss">
            <img src="<?= url('/assets/images/logo/Pfadibewegung_Schweiz_Logo_negativ_digital.png') ?>" alt="pbs">
        </a>

        <a href="https://www.pfadi-sgarai.ch/">
            <img src="<?= url('/assets/images/logo/kvlogo_3.png') ?>" alt="sgarai">
        </a>

        <a href="https://www.jugendundsport.ch">
            <img src="<?= url('/assets/images/logo/J+S_d_f_neg.png') ?>" alt="j+s">
        </a>

        <a href="https://www.hajk.ch">
            <img src="<?= url('/assets/images/logo/hajk_logo.png') ?>" alt="hajk">
        </a>
    </div>

    
</footer>