<?php
/**
 *
 * @package Social Share Buttons
 * @author  Victor Freitas
 * @subpackage Views Sharing Report
 * @version 1.0.0
 */

namespace JM\Share_Buttons;

// Avoid that files are directly loaded
if ( ! function_exists( 'add_action' ) ) :
	exit(0);
endif;

class Sharing_Report_View
{
	public static function render_sharing_report( $posts, $prev_page, $next_page )
	{
		?>
		<div class="wrap">
			<h2><?php echo Settings::PLUGIN_NAME; ?></h2>
			<p class="description">Relatório de Compartilhamento dos Posts</p>
			<p></p>
			<p class="description">Esta página tem um cache de 10 minutos</p>
			<?php
				if ( ! $posts ) :
			?>
			<h3>Não existe mais resultados</h3>
			<a href="javascript:window.history.go(-1);">Voltar</a>
			<?php
					return;
				endif;
			?>
			<table class="widefat jm-ssb-sharing-report-table">
				<thead>
					<tr>
						<th scope="col">
							<span>Título</span>
						</th>
						<th scope="col" class="jm-ssb-sharing-report-center">
							<span>Facebook</span>
						</th>
						<th scope="col" class="jm-ssb-sharing-report-center">
							<span>Twitter</span>
						</th>
						<th scope="col" class="jm-ssb-sharing-report-center">
							<span>Google+</span>
						</th>
						<th scope="col" class="jm-ssb-sharing-report-center">
							<span>Linkedin</span>
						</th>
						<th scope="col" class="jm-ssb-sharing-report-center">
							<span>Pinterest</span>
						</th>
						<th scope="col" class="jm-ssb-sharing-report-center">
							<span>Total</span>
						</th>
					</tr>
				</thead>
				<tbody>
				<?php foreach( $posts as $key => $post ) : ?>
					<tr>
						<td>
							<strong>
								<a href="<?php echo esc_url( get_permalink( $post->ID ) ); ?>" target="_blank"
								   title="<?php echo esc_attr( $post->post_title ); ?>">
								   <?php echo esc_html( $post->post_title ); ?>
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