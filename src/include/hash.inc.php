<?php
// These constants may be changed without breaking existing hashes.
define("PBKDF2_HASH_ALGORITHM", "sha512");
define("PBKDF2_ITERATIONS", 500);
define("PBKDF2_SALT_BYTES", 4);
define("PBKDF2_HASH_BYTES", 64);
define("HASH_SECTIONS", 4);
define("HASH_ALGORITHM_INDEX", 0);
define("HASH_ITERATION_INDEX", 1);
define("HASH_SALT_INDEX", 2);
define("HASH_PBKDF2_INDEX", 3);
define("Salt",base64_encode(mcrypt_create_iv(PBKDF2_SALT_BYTES, MCRYPT_DEV_URANDOM)));
