<?php

namespace App\Http\Controllers\Api;

use App\Repositories\SettingRepository;
use Illuminate\Http\Request;

class SettingController extends ApiController
{
    /**
     * @var SettingRepository
     */
    protected $setting;

    /**
     * SettingController constructor.
     * @param SettingRepository $setting
     */
    public function __construct(SettingRepository $setting)
    {
        $this->setting = $setting;
    }

    /**
     * Get all friend links.
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function links()
    {
        return $this->setting->getFriendLinks();
    }

    /**
     * Get logged in user information.
     *
     * @return \App\Models\Admin
     */
    public function auth()
    {
        return $this->setting->getAuthInfo();
    }

    /**
     * Store new friend link.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeLink(Request $request)
    {
        $this->validateLink($request);
        $result = $this->setting->createLink($request->all());

        return $result ?
            response()->json($result, REST_CREATE_SUCCESS):
            response()->json([
                'error' => FAIL_TO_ADD_LINK,
                'message' => trans('post.add_link_fail')
            ], REST_BAD_REQUEST);
    }

    /**
     * Update an existent link.
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateLink(Request $request, $id)
    {
        $this->validateLink($request);
        $result = $this->setting->updateLink($id, $request->all());

        return $result ?
            response()->json([], REST_UPDATE_SUCCESS):
            response()->json([
                'error' => FAIL_TO_UPDATE_LINK,
                'message' => trans('post.update_link_fail')
            ], REST_BAD_REQUEST);
    }

    /**
     * Validate link form.
     *
     * @param $request
     */
    private function validateLink($request)
    {
        $this->validate($request, [
            'name' => 'required|string|between:1,20',
            'link' => 'required|url',
        ]);
    }

    /**
     * Destroy link.
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroyLink($id)
    {
        $result = $this->setting->destroyLink($id);

        return $result ?
            response()->json([], REST_DELETE_SUCCESS):
            response()->json([
                'error' => FAIL_TO_UPDATE_LINK,
                'message' => trans('post.delete_link_fail')
            ], REST_BAD_REQUEST);
    }

    /**
     * Update logged user information.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateAuth(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:20',
            'email' => 'required|email',
            'password' => 'confirmed|alpha_dash|between:6,25',
        ]);

        $result = $this->setting->updateAuth($request->all());
        return $result ?
            response()->json([], REST_UPDATE_SUCCESS):
            response()->json([
                'error' => FAIL_TO_UPDATE_AUTH,
                'message' => trans('post.update_auth_fail')
            ], REST_BAD_REQUEST);
    }
}
