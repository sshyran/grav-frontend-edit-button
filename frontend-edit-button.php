<?php
/**
 * FrontendEditButton
 *
 * This plugin adds an 'edit this page' button on the frontend
 *
 * Licensed under MIT, see LICENSE.
 */

namespace Grav\Plugin;

use Grav\Common\Plugin;
use RocketTheme\Toolbox\Event\Event;

/**
 * Class FrontendEditButtonPlugin
 * @package Grav\Plugin
 */
class FrontendEditButtonPlugin extends Plugin {

	private $_config = NULL;
	private $_page = NULL;

	/**
	 * @function getSubscribedEvents
	 * @return array
	 */
	public static function getSubscribedEvents() {
		return [
			'onPluginsInitialized' => [ 'onPluginsInitialized', 0 ]
		];
	}

	/**
	 * @event onPluginsInitialized
	 *
	 * It is only allowed to process when:
	 * - Admin is logged in in any of the other tabs
	 * - Login plugin is enabled
	 * - Admin plugin is enabled
	 * - This plugin is enabled (but that it is)
	 * - Page has no frontmatter: pageProtect: true
	 *
	 */
	public function onPluginsInitialized() {
		if ( $this->isAdmin() ) {
			return;
		}

		$adminCookie = session_name() . '-admin';
		if ( isset( $_COOKIE[ $adminCookie ] ) === false ) {
			return;
		}

		$config  = $this->grav['config'];
		$plugins = $config->get( 'plugins' );

		$adminPlugin = isset( $plugins['admin'] ) ? $this->config->get( 'plugins.admin' ) : false;
		$loginPlugin = isset( $plugins['login'] ) ? $this->config->get( 'plugins.login' ) : false;

		// Works only with the login and admin plugin installed and enabled
		if ( $adminPlugin === false || $loginPlugin === false ) {
			return;
		} else {
			if ( $adminPlugin['enabled'] === false || $loginPlugin['enabled'] === false ) {
				return;
			}
		}

		$this->enable( [
			'onPageContentProcessed' => [ 'onPageContentProcessed', 0 ],
			'onOutputGenerated'   => [ 'onOutputGenerated', 0 ],
			'onTwigTemplatePaths' => [ 'onTwigTemplatePaths', 0 ]
		] );
	}

	/**
	 * @event onPageContentProcessed
	 * @param Event $event
	 */
	public function onPageContentProcessed( Event $event ) {
		$page          = $event['page'];
		$this->_config  = $this->mergeConfig( $page );
		$this->_page = $event['page'];

	}

	/**
	 * @event onOutputGenerated
	 */
	public function onOutputGenerated() {
		if ( $this->isAdmin() ) {
			return;
		}

		$header = $this->_page->header();

		if (isset($header->protectEdit) && $header->protectEdit == true) {
			return;
		}

		$content = $this->grav->output;
		$twig    = $this->grav['twig'];

		$position = $this->config->get( 'plugins.frontend-edit-button.position' );

		$vertical   = substr( $position, 0, 1 ) === 't' ? 'top' : 'bottom';
		$horizontal = substr( $position, 1, 1 ) === 'l' ? 'left' : 'right';

		$page    = $this->grav['page'];
		$pageUrl = $page->url( false, false, true, false );
		$editUrl = '/admin/pages' . $pageUrl;

		$insertThis = $twig->processTemplate( 'partials/edit-button.html.twig', array(
			'config'     => $this->_config,
			'header'     => $this->_page->header(),
			'horizontal' => $horizontal,
			'vertical'   => $vertical,
			'pageUrl'    => $pageUrl,
			'editUrl'    => $editUrl
		) );

		$pos = strpos( $content, '<body', 0 );

		if ( $pos > 0 ) {

			$pos = strpos( $content, '>', $pos );

			if ( $pos > 0 ) {

				$str1 = substr( $content, 0, $pos + 1 );
				$str2 = substr( $content, $pos + 1 );

				$content = $str1 . $insertThis . $str2;

				$this->grav->output = $content;
			}
		}
	}

	public function onTwigTemplatePaths() {
		$this->grav['twig']->twig_paths[] = __DIR__ . '/templates';
	}
}