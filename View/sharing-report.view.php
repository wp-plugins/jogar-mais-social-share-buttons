<?php
/**
 *
 * @package Social Sharing Buttons
 * @author  Victor Freitas
 * @subpackage Views Sharing Report
 * @version 1.4.0
 */

namespace JM\Share_Buttons;

// Avoid that files are directly loaded
if ( ! function_exists( 'add_action' ) )
	exit(0);

class Sharing_Report_View
{
	/**
	 * Display page sharing report
	 * 
	 * @since 1.3
	 * @param Object $list_table
	 * @return void
	 */
	public static function render_sharing_report( $list_table )
	{
		$time_cache = Utils_Helper::option( '_report_cache_time', 'intval', 10 );
		?>
		<div class="wrap">
			<h2><?php _e( 'Social Sharing Buttons', Init::PLUGIN_SLUG ); ?></h2>
			<p class="description"><?php _e( 'Adiciona os botões de compartilhamento automáticamente em posts e páginas', Init::PLUGIN_SLUG ); ?></p>
			<span class="<?php echo Settings::PLUGIN_PREFIX; ?>-settings-title">
				<?php _e( 'Relatório de Compartilhamento', Init::PLUGIN_SLUG ); ?>
				<span class="description information-cache">
					<?php printf( __( 'Este relatório tem um cache de %d minuto', Init::PLUGIN_SLUG ), $time_cache ); ?>(s)
				</span>
			</span>
			<div class="<?php echo Settings::PLUGIN_PREFIX; ?>-settings-wrap">
				<?php
					$list_table->prepare_items();
					$list_table->display();
				?>
			</div>
		</div>
		<?php
	}

	/**
	 * Insert link in column title in wp list table
	 * 
	 * @since 1.0
	 * @param Integer $id
	 * @param String $post_title
	 * @return String
	 */
	public static function add_permalink_title( $id, $post_title )
	{
		$permalink = get_permalink( $id );
		$html      = "<a class=\"row-title\" href=\"{$permalink}\">{$post_title}</a>";

		return $html;
	}
}