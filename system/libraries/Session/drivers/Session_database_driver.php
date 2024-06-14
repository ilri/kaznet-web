<?php
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2014 - 2019, British Columbia Institute of Technology
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package    CodeIgniter
 * @author     EllisLab Dev Team
 * @copyright  Copyright (c) 2008 - 2014, EllisLab, Inc. (https://ellislab.com/)
 * @copyright  Copyright (c) 2014 - 2019, British Columbia Institute of Technology (https://bcit.ca/)
 * @license    https://opensource.org/licenses/MIT  MIT License
 * @link       https://codeigniter.com
 * @since      Version 3.0.0
 * @filesource
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * CodeIgniter Session Database Driver
 *
 * @package CodeIgniter
 * @subpackage Libraries
 * @category Sessions
 * @author Andrey Andreev
 * @link https://codeigniter.com/user_guide/libraries/sessions.html
 */
class CI_Session_database_driver extends CI_Session_driver implements SessionHandlerInterface
{
    /**
     * Database object
     *
     * @var object
     */
    protected $_db;

    /**
     * Row exists flag
     *
     * @var bool
     */
    protected $_row_exists = FALSE;

    // ------------------------------------------------------------------------

    /**
     * Class constructor
     *
     * @param array $params Configuration parameters
     * @return void
     */
    public function __construct(&$params)
    {
        parent::__construct($params);

        // Note: CI's database class doesn't allow usage of $this->CI, so we
        // reference it directly as a property.
        $CI =& get_instance();
        $this->_db = $CI->load->database($this->_config['sess_save_path'], TRUE, TRUE);
    }

    // ------------------------------------------------------------------------

    /**
     * Open
     *
     * Initializes the database connection
     *
     * @param string $save_path Table name
     * @param string $name Session cookie name, unused
     * @return bool
     */
    public function open(string $save_path, string $name): bool
    {
        return $this->_config_db();
    }

    // ------------------------------------------------------------------------

    /**
     * Close
     *
     * Closes the current session
     *
     * @return bool
     */
    public function close(): bool
    {
        return $this->_close();
    }

    // ------------------------------------------------------------------------

    /**
     * Read
     *
     * Reads session data
     *
     * @param string $session_id Session ID
     * @return string|false
     */
    public function read(string $session_id): string|false
    {
        return $this->_read($session_id);
    }

    // ------------------------------------------------------------------------

    /**
     * Write
     *
     * Writes session data
     *
     * @param string $session_id Session ID
     * @param string $session_data Serialized session data
     * @return bool
     */
    public function write(string $session_id, string $session_data): bool
    {
        return $this->_write($session_id, $session_data);
    }

    // ------------------------------------------------------------------------

    /**
     * Destroy
     *
     * Destroys the current session
     *
     * @param string $session_id Session ID
     * @return bool
     */
    public function destroy(string $session_id): bool
    {
        return $this->_destroy($session_id);
    }

    // ------------------------------------------------------------------------

    /**
     * Garbage Collector
     *
     * Deletes expired sessions
     *
     * @param int $maxlifetime Maximum lifetime of sessions
     * @return int|false
     */
    public function gc(int $maxlifetime): int|false
    {
        return $this->_gc($maxlifetime);
    }

    // ------------------------------------------------------------------------

    /**
     * Config database
     *
     * @return bool
     */
    protected function _config_db()
    {
        $this->_db = $this->CI->load->database($this->_config['sess_save_path'], TRUE, TRUE);
        return TRUE;
    }

    // ------------------------------------------------------------------------

    /**
     * Close session (custom implementation)
     *
     * @return bool
     */
    protected function _close()
    {
        return TRUE;
    }

    // ------------------------------------------------------------------------

    /**
     * Read session (custom implementation)
     *
     * @param string $session_id Session ID
     * @return string|false
     */
    protected function _read($session_id)
    {
        $this->_db->reset_query();
        $this->_db->select('data');
        $this->_db->from($this->_config['sess_save_path']);
        $this->_db->where('id', $session_id);

        if ($this->_config['match_ip'])
        {
            $this->_db->where('ip_address', $this->CI->input->ip_address());
        }

        $this->_db->limit(1);
        $result = $this->_db->get();

        if ($result->num_rows() === 0)
        {
            return '';
        }

        $row = $result->row();
        return ($row->data === NULL) ? '' : $row->data;
    }

    // ------------------------------------------------------------------------

    /**
     * Write session (custom implementation)
     *
     * @param string $session_id Session ID
     * @param string $session_data Serialized session data
     * @return bool
     */
    protected function _write($session_id, $session_data)
    {
        $this->_db->reset_query();

        $payload = array(
            'id' => $session_id,
            'ip_address' => $this->CI->input->ip_address(),
            'timestamp' => time(),
            'data' => $session_data
        );

        $this->_db->where('id', $session_id);

        if ($this->_config['match_ip'])
        {
            $this->_db->where('ip_address', $this->CI->input->ip_address());
        }

        $result = $this->_db->update($this->_config['sess_save_path'], $payload);
        if ($this->_db->affected_rows() === 0)
        {
            $result = $this->_db->insert($this->_config['sess_save_path'], $payload);
        }

        return ($result) ? TRUE : FALSE;
    }

    // ------------------------------------------------------------------------

    /**
     * Destroy session (custom implementation)
     *
     * @param string $session_id Session ID
     * @return bool
     */
    protected function _destroy($session_id)
    {
        $this->_db->reset_query();
        $this->_db->where('id', $session_id);

        if ($this->_config['match_ip'])
        {
            $this->_db->where('ip_address', $this->CI->input->ip_address());
        }

        return $this->_db->delete($this->_config['sess_save_path']);
    }

    // ------------------------------------------------------------------------

    /**
     * Garbage collection (custom implementation)
     *
     * @param int $maxlifetime Maximum lifetime of sessions
     * @return int|false
     */
    protected function _gc($maxlifetime)
    {
        $this->_db->reset_query();
        $this->_db->where('timestamp <', time() - $maxlifetime);

        return $this->_db->delete($this->_config['sess_save_path']);
    }
}
