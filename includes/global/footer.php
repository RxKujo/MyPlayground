<?php

include_once '../../includes/global/session.php';

$user = $_SESSION['user_info'] ?? null;

$isSubscribed = isUserSubscribed($pdo, $user['id']);

?>

<footer class="bg-black text-white pt-4 pb-2">
    <div class="container-fluid">
        <a class="btn btn-black text-black" href="https://www.youtube.com/watch?v=dQw4w9WgXcQ&list=RDdQw4w9WgXcQ&start_radio=1&pp=ygUXbmV2ZXIgZ29ubmEgZ2l2ZSB5b3UgdXCgBwE%3D">easteregg</a>
        <div class="row align-items-center justify-content-end">
       
            <div class="col-md-7 offset-md-1 text-center text-md-start mb-3 mb-md-0">
                <p class="mb-2">© 2025 Basketball Platform. Tous droits réservés.</p>
                <div class="d-inline-flex gap-4">
                    <a href="privacy-policy.html" class="text-white text-decoration-underline">Politique de confidentialité</a>
                    
                    <a href="/contact.php" class="text-white text-decoration-underline">Contact</a>
                </div>
            </div>
            
            <?php if (!$isSubscribed): ?>
            <div class="col-md-4">
                <form action="newsletter.php" method="POST" class="d-flex flex-column flex-sm-row align-items-center justify-content-md-end gap-2"> 
                    <button type="submit" class="btn btn-secondary" style="height: 38px;">S'abonner à la Newsletter :</button>
                    <input type="email" class="form-control text-dark" name="email" placeholder="Adresse email" required style="max-width:200px;">
                </form>
            </div>

            <?php else: ?>
            <div class="text-end mt-1">
                <a href="/newsletter_unsubscribe.php" class="text-light" style="font-size: 0.75rem; text-decoration: underline;">
                    Se désabonner
                </a>
            </div>
            <?php endif; ?>
        </div>
    </div>
</footer>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
