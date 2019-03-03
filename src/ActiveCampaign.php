<?php

namespace Codeception\Module;

use PHPUnit\Framework\Assert;
use ActiveCampaign as ActiveCampaignClient;

class ActiveCampaign extends EmailMarketing {

	/**
	 * @var ActiveCampaignClient
	 */
	protected static $client;

	/**
	 * @return ActiveCampaignClient
	 */
	protected function getClient() {
		if ( empty( $this::$client ) ) {
			$this::$client = new ActiveCampaignClient( $this->config['api_url'], $this->config['api_key'] );
		}

		return $this::$client;
	}
	/**
	 * Get a subscriber by email address.
	 *
	 * @param string $email
	 *
	 * @return mixed
	 */
	protected function getSubscriber( $email ) {
		$contact = $this->getClient()->api('contact/view?email=' . $email );

		return $contact;
	}

	/**
	 * Get the campaigns for a subscriber.
	 *
	 * @param string      $email
	 * @param null|string $status Status of the subscription, eg. active
	 *
	 * @return mixed
	 */
	public function getCampaignsForSubscriber( $email, $status = null ) {
		$contact = $this->getSubscriber( $email );

		if ( ! isset( $contact->id ) ) {
			Assert::fail( 'Contact not found' );
		}

		$lists = array();
		foreach ( $contact->lists as $list ) {
			if ( $status === 'active' && 1 != $list->status ) {
				continue;
			}

			$lists[] = (int) $list->list;
		}

		return $lists;
	}

	/**
	 * Get the tags for a subscriber.
	 *
	 * @param string $email
	 *
	 * @return array
	 */
	public function getTagsForSubscriber( $email ) {
		$contact = $this->getSubscriber( $email );

		if ( ! isset( $contact->id ) ) {
			Assert::fail( 'Contact not found' );
		}

		return $contact->tags;
	}

	/**
	 * Get the value of a custom field for a subscriber.
	 *
	 * @param string $email
	 * @param string $field_name
	 *
	 * @return mixed
	 */
	protected function getSubscriberCustomField( $email, $field_name ) {
		$contact = $this->getSubscriber( $email );

		if ( ! isset( $contact->id ) ) {
			Assert::fail( 'Contact not found' );
		}

		foreach ( $contact->fields as $field ) {
			if ( $field->title === $field_name ) {
				return $field->val;
			}
		}

		return false;
	}

	/**
	 * Delete a subscriber.
	 *
	 * @param string $email
	 *
	 * @return mixed
	 */
	public function deleteSubscriber( $email ) {
		$contact = $this->getSubscriber( $email );

		if ( ! isset( $contact->id ) ) {
			return;
		}

		$this->getClient()->api( 'contact_delete/?id=' . $contact->id );
	}
}