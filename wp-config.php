<?php
/**
 * As configurações básicas do WordPress
 *
 * O script de criação wp-config.php usa esse arquivo durante a instalação.
 * Você não precisa usar o site, você pode copiar este arquivo
 * para "wp-config.php" e preencher os valores.
 *
 * Este arquivo contém as seguintes configurações:
 *
 * * Configurações do MySQL
 * * Chaves secretas
 * * Prefixo do banco de dados
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Configurações do MySQL - Você pode pegar estas informações com o serviço de hospedagem ** //
/** O nome do banco de dados do WordPress */
define( 'DB_NAME', 'smcwordpress' );

/** Usuário do banco de dados MySQL */
define( 'DB_USER', 'root' );

/** Senha do banco de dados MySQL */
define( 'DB_PASSWORD', '' );

/** Nome do host do MySQL */
define( 'DB_HOST', 'localhost' );

/** Charset do banco de dados a ser usado na criação das tabelas. */
define( 'DB_CHARSET', 'utf8mb4' );

/** O tipo de Collate do banco de dados. Não altere isso se tiver dúvidas. */
define( 'DB_COLLATE', '' );

/**#@+
 * Chaves únicas de autenticação e salts.
 *
 * Altere cada chave para um frase única!
 * Você pode gerá-las
 * usando o {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org
 * secret-key service}
 * Você pode alterá-las a qualquer momento para invalidar quaisquer
 * cookies existentes. Isto irá forçar todos os
 * usuários a fazerem login novamente.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'dk{{~va_tAn<e/=p~VCa--L-{@@KWhV$/$ha=fLqcJ[n(_/[9DrzcH~rKqC.|{$_' );
define( 'SECURE_AUTH_KEY',  'Vc|uz=-Wm<r#;{%}F7u phGs0iw&ksOil0G~[dv~(t?O-5sIxuN8Ee@nPGrWRmI(' );
define( 'LOGGED_IN_KEY',    '.eOly/-LUn!MdjMnoOfl4jv6m2Fa1V[Lt0LY]aee%l:{C4irHZ0DfFfG&,.2cc*U' );
define( 'NONCE_KEY',        ',>-dv(5sm5@H(_n6#i70(mwT~S-Sw6PUXOM1gRd^2.Nma@B_>s,~M-pf{<,rH3g4' );
define( 'AUTH_SALT',        'GFbuzrP:Y.oME~u<@dLdd9QK.vexgy4Ehm)xq0G%ZbnO !&)Q vgMn4^AhHhAX/H' );
define( 'SECURE_AUTH_SALT', '5r qKu8tG V+<u.l8:-$_$%.RQDp!xcqi#(sXYx=Iq5TLLsbTZg>XQ!hfsKd~C_ ' );
define( 'LOGGED_IN_SALT',   'n,pdz@&rA[et~k/ippoIC4v>C<Mg#f<p]_9lz5oEdJT;jd,,/4-Mb]uPuwH?sSuC' );
define( 'NONCE_SALT',       ',:IJ;|MRS^;g/n)C!+Z]eftS]T0B4CgiiCb%O6Q<OBL.HRYJW(mi%>0LUWM(`KZd' );

/**#@-*/

/**
 * Prefixo da tabela do banco de dados do WordPress.
 *
 * Você pode ter várias instalações em um único banco de dados se você der
 * um prefixo único para cada um. Somente números, letras e sublinhados!
 */
$table_prefix = 'smc_';

/**
 * Para desenvolvedores: Modo de debug do WordPress.
 *
 * Altere isto para true para ativar a exibição de avisos
 * durante o desenvolvimento. É altamente recomendável que os
 * desenvolvedores de plugins e temas usem o WP_DEBUG
 * em seus ambientes de desenvolvimento.
 *
 * Para informações sobre outras constantes que podem ser utilizadas
 * para depuração, visite o Codex.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Adicione valores personalizados entre esta linha até "Isto é tudo". */



/* Isto é tudo, pode parar de editar! :) */

/** Caminho absoluto para o diretório WordPress. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Configura as variáveis e arquivos do WordPress. */
require_once ABSPATH . 'wp-settings.php';
