<?php
// components/footer.php
// Inclure ce fichier en bas de chaque page avec : require_once '../components/footer.php';
?>

<footer>
    <p>&copy;  2025 Bijoux Store — Tous droits réservés</p>
</footer>

<?php if (!empty($extraJs)): ?>
    <?php foreach ($extraJs as $js): ?>
        <script src="<?php echo $js; ?>"></script>
    <?php endforeach; ?>
<?php endif; ?>

</body>
</html>
