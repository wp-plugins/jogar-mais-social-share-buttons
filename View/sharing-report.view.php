<?php
/**
 *
 * @package Social Share Buttons
 * @author  Victor Freitas
 * @subpackage Views Sharing Report
 * @version 1.0.1
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
	 * @since 1.0
	 * @param Object $post
	 * @param String $prev_page
	 * @param String $next_page
	 * @return void
	 */
	public static function render_sharing_report( $posts, $prev_page, $next_page )
	{
		$page_url = 'admin.php?page=' . Init::PLUGIN_SLUG . '-sharing-report';

		?>
		<div class="wrap">
			<h2><?php echo Settings::PLUGIN_NAME; ?></h2>
			<p class="description">Relatório de Compartilhamento dos Posts</p>
			<p></p>
			<p class="description">Esta página tem um cache de <?php echo Utils_Helper::option( '_report_cache_time', 'intval', 10 ); ?> minuto(s)</p>
			<?php
				if ( ! $posts ) :
			?>
			<h3>Não existe mais resultados</h3>
			<a href="javascript:window.history.go(-1);">Voltar</a>
			<?php
					return false;
				endif;
			?>
			<table class="widefat fixed jm-ssb-sharing-report-table">
				<thead>
					<tr>
						<th scope="col" class="<?php echo Utils_Helper::sortable_order( 'title' ); ?>">
							<a href="<?php echo Utils_Helper::get_url_orderby_page( 'title', $page_url ); ?>">
								<span>Título</span>
								<span class="sorting-indicator"></span>
							</a>
						</th>
						<th scope="col" class="<?php echo Utils_Helper::sortable_order( 'facebook' ); ?>">
							<a href="<?php echo Utils_Helper::get_url_orderby_page( 'facebook', $page_url ); ?>">
								<span>Facebook</span>
								<span class="sorting-indicator"></span>
							</a>
						</th>
						<th scope="col" class="<?php echo Utils_Helper::sortable_order( 'twitter' ); ?>">
							<a href="<?php echo Utils_Helper::get_url_orderby_page( 'twitter', $page_url ); ?>">
								<span>Twitter</span>
								<span class="sorting-indicator"></span>
							</a>
						</th>
						<th scope="col" class="<?php echo Utils_Helper::sortable_order( 'google' ); ?>">
							<a href="<?php echo Utils_Helper::get_url_orderby_page( 'google', $page_url ); ?>">
								<span>Google+</span>
								<span class="sorting-indicator"></span>
							</a>
						</th>
						<th scope="col" class="<?php echo Utils_Helper::sortable_order( 'linkedin' ); ?>">
							<a href="<?php echo Utils_Helper::get_url_orderby_page( 'linkedin', $page_url ); ?>">
								<span>Linkedin</span>
								<span class="sorting-indicator"></span>
							</a>
						</th>
						<th scope="col" class="<?php echo Utils_Helper::sortable_order( 'pinterest' ); ?>">
							<a href="<?php echo Utils_Helper::get_url_orderby_page( 'pinterest', $page_url ); ?>">
								<span>Pinterest</span>
								<span class="sorting-indicator"></span>
							</a>
						</th>
						<th scope="col" class="<?php echo Utils_Helper::sortable_order( 'total' ); ?>">
							<a href="<?php echo Utils_Helper::get_url_orderby_page( 'total', $page_url ); ?>">
								<span>Total</span>
								<span class="sorting-indicator"></span>
							</a>
						</th>
					</tr>
				</thead>
				<tbody>
				<?php foreach( $posts as $key => $post ) : ?>
					<tr>
						<td>
							<strong>
								<a href="<?php echo esc_url( get_permalink( $post->ID ) ); ?>" target="_blank"
								   title="<?php echo esc_attr( $post->title ); ?>">
								   <?php echo esc_html( $post->title ); ?>
								</a>
							</strong>
						</td>
						<td class="jm-ssb-sharing-report-center">
							<?php echo intval( $post->facebook ); ?>
						</td>
						<td class="jm-ssb-sharing-report-center">
							<?php echo intval( $post->twitter ); ?>
						</td>
						<td class="jm-ssb-sharing-report-center">
							<?php echo intval( $post->google ); ?>
						</td>
						<td class="jm-ssb-sharing-report-center">
							<?php echo intval( $post->linkedin ); ?>
						</td>
						<td class="jm-ssb-sharing-report-center">
							<?php echo intval( $post->pinterest ); ?>
						</td>
						<td class="jm-ssb-sharing-report-center">
							<?php echo intval( $post->total ); ?>
						</td>
					</tr>
				<?php endforeach; ?>
				</tbody>
			</table>
			<div class="tablenav bottom">
				<div class="tablenav-pages">
					<a class="prev-page <?php echo ( ( $prev_page === '#' ) ? 'disabled' : '' ); ?>" rel="prev" title="Página anterior"
					   href="<?php echo $prev_page; ?>">
						&laquo;
					</a>
					<a class="next-page <?php echo ( ( $next_page === '#' ) ? 'disabled' : '' ); ?>" rel="next" title="Próxima página"
					   href="<?php echo $next_page; ?>">
						&raquo;
					</a>
				</div>
			</div>
		</div>
		<?php
	}
}