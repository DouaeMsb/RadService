<?php
$title = "RadService – Fahrradreparatur online buchen";
require 'partials/head.php';
require 'partials/header.php';
?>

<main>
     <section id="intro">
          <h2>Ihr Rad, unsere Werkstatt</h2>
          <p>Geben Sie Ihr Fahrrad bequem online zur Reparatur ab — wir kümmern uns um den Rest.</p>
          <img id="logo" src="/assets/img/RadServiceLogo.png"
               alt="RadService Logo – stilisiertes Fahrrad-Zahnrad"
               width="250" height="250">
     </section>

     <section id="order-form">
          <h2 id="order-form-heading">Rad zur Reparatur abgeben</h2>

          <form action="#" method="post">
               <div class="form-group">
                    <label for="bikeType">Fahrradtyp</label>
                    <select id="bikeType" name="bikeType" required>
                         <option value="" disabled selected>Bitte wählen</option>
                         <option value="rennrad">Rennrad</option>
                         <option value="mountainbike">Mountainbike</option>
                         <option value="ebike">E-Bike</option>
                    </select>
               </div>

               <div class="form-group">
                    <label for="problem">Problembeschreibung</label>
                    <textarea id="problem" name="problem" required minlength="10"
                         placeholder="z.B. Bremsen quietschen, Kette springt..."></textarea>
               </div>

               <fieldset class="form-group">
                    <legend>Priorität</legend>
                    <label><input type="radio" name="priority" value="niedrig"> Niedrig</label>
                    <label><input type="radio" name="priority" value="mittel" checked> Mittel</label>
                    <label><input type="radio" name="priority" value="hoch"> Hoch</label>
               </fieldset>

               <div class="form-group">
                    <label for="dueDate">Wunschtermin</label>
                    <input type="date" id="dueDate" name="dueDate">
               </div>

               <div class="form-group">
                    <label for="address">Ihre Adresse</label>
                    <input type="text" id="address" name="address" required
                         minlength="5" placeholder="Straße, PLZ, Ort">
               </div>

               <button type="submit" class="btn-submit">
                    Auftrag absenden
               </button>
          </form>
     </section>
</main>

<?php require 'partials/footer.php'; ?>