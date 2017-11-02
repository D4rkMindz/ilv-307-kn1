<?php $this->layout('view::Layout/layout.html.php'); ?>
<div data-id="items">
    <?php foreach ($this->v('data') as $item): ?>
        <div class="cart-item">
            <button class="button inline" onclick="edit(this)" data-value="<?= $this->e($item['count']) ?>">Bearbeiten
            </button>
            <button class="button inline hidden" data-id="save" onclick="save(this)">Speichern</button>
            <button class="button inline" style="background-color: red; border: 1px solid darkred"
                    onclick="deleteItem(this)">Löschen
            </button>
            <h3 class="inline title"><?= $this->e($item['id']) ?> <span data-id="count">(<?= $this->e($item['count']) ?>
                    stk.) - CHF <?= $this->e($item['price']) ?></span></h3>
            <input type="hidden" value="<?= $this->e($item['price']) ?>">
            <input type="number" class="input count inline no-margin hidden" value="<?= $this->e($item['count']) ?>"
                   data-item-id="<?= $this->e($item['id']) ?>">
        </div>
    <?php endforeach; ?>
</div>
<?php if ($this->v('count') >= 1): ?>
    <div class="order">
        <h3>Bestellart</h3>
        <label for="standard">
            Standard (CHF 10.-)
        </label>
        <input type="radio" id="standard" name="delivery-type" value="10" checked="checked" onchange="ajustPrice()">
        <br/>
        <label for="express">
            Express (CHF 30.-)
        </label>
        <input type="radio" id="express" name="delivery-type" value="30" onchange="ajustPrice()">
        <br/>
        <label for="pick-up">
            Abholung (CHF 0.-)
        </label>
        <input type="radio" id="pick-up" name="delivery-type" value="0" onchange="ajustPrice()">
        <br/>
        <h4 class="inline">Total:</h4>
        <p class="price" data-id="price"> Berechnung läuft . . .</p>
        <br/>
        <div data-id="form">
            <select data-id="salutation">
                <option value="Herr">Herr</option>
                <option value="Frau">Frau</option>
                <option value="Nichts">Irgend etwas</option>
            </select>
            <input type="hidden" data-id="total">
            <input type="text" class="input" data-id="firstname" placeholder="Vorname" required>
            <span class="help-block" data-id="firstname-error"></span>
            <input type="text" class="input" data-id="lastname" placeholder="Nachname" required>
            <span class="help-block" data-id="lastname-error"></span>
            <input type="text" class="input" data-id="birthday" placeholder="Geburtstag">
            <span class="help-block" data-id="birthday-error"></span>
            <input type="text" class="input" data-id="street" placeholder="Strasse" required>
            <span class="help-block" data-id="street-error"></span>
            <input type="number" class="input" data-id="postcode" placeholder="PLZ" required>
            <span class="help-block" data-id="postcode-error"></span>
            <input type="text" class="input" data-id="city" placeholder="Ort" required>
            <span class="help-block" data-id="city-error"></span>
            <input type="email" class="input" data-id="mail" placeholder="Email" required>
            <span class="help-block" data-id="mail-error"></span>
            <input type="text" class="input" data-id="captcha" placeholder="Please enter the captcha code" required>
            <span class="help-block" data-id="captcha-error"></span>
        </div>
        <div class="captcha">
            <img src="<?= $this->v('captcha')?>" alt="captcha">
        </div>
        <button class="button" onclick="order()">
            Bestellen
        </button>
    </div>
    <script>
        $(function () {
            ajustPrice();
        });
    </script>
<?php endif; ?>
