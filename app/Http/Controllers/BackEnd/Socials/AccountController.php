<?php

namespace App\Http\Controllers\BackEnd\Socials;

use App\Core\Traits\ApiResponser;
use App\Http\Requests\Account\CreateAccountRequest;
use App\Repositories\Languages\Contract\LanguageRepositoryInterface;
use App\Repositories\Profile\Contract\ProfileRepositoryInterface;
use App\Repositories\UserMazii\Contract\UserMaziiRepositoryInterface;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use JavaScript;

class AccountController extends Controller
{
    use ApiResponser;
    private $profile;
    private $userMazii;
    private $language;

    public function __construct(UserMaziiRepositoryInterface $userMazii, ProfileRepositoryInterface $profile, LanguageRepositoryInterface $language)
    {
        $this->userMazii = $userMazii;
        $this->profile = $profile;
        $this->language = $language;
    }

    // List Tài khoản
    public function index()
    {
        $userMazii = $this->userMazii->WithAll()->paginate();
        $languages = $this->language->all();
        $views = view('backend.social.account');
        JavaScript::put([
            'user' => $userMazii,
            'link_create_account' => route('backend.social.account.create'),
            'link_delete_account' => route('backend.social.account.delete')
        ]);
        $views->with('userMazii', $userMazii);
        $views->with('languages', $languages);
        return $views;
    }

    // Create User
    public function create(CreateAccountRequest $request)
    {
        DB::transaction(function () use ($request) {
            $data = [
                'username' => $request->get('username'),
                'email' => $request->get('email'),
                'language_id' => $request->get('language'),
                'password' => config('access.password_default')
            ];
            $user = $this->userMazii->create($data);
            $profiles = [
                'user_id' => $user->userId,
                'profile_name' => 'user',
                'name' => $user->username,
                'email' => $user->email,
                'image' => $request->file('image'),
                "private" => 'email-phone-facebook-address-sex-birthday'
            ];
            $this->profile->createOrUpdate($profiles);
            return $this->success($user, 200);
        });
    }

    // Delete User
    public function delete()
    {
            $id = request('id');
            $attributeUser = [
                'userId' => $id
            ];
            $attributeProfile = [
                'user_id' => $id
            ];
            $this->userMazii->deleteAttribute($attributeUser);
            $this->profile->deleteAttribute($attributeProfile);
            return $this->success('Xóa thành công', 200);
    }
}
