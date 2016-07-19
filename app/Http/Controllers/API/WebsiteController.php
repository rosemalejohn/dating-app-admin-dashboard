<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Website;
use Illuminate\Http\Request;
use Image;

class WebsiteController extends Controller
{
    public function index()
    {
        $websites = Website::all();

        return response()->json($websites);
    }

    public function store(Request $request)
    {
        $this->validate($request, $this->validator($request->all()));

        $website = Website::create($this->getWebsite($request));
        return response()->json($website, 201);
    }

    public function update(Request $request, Website $website)
    {
        $website->update($request->all());
        return response()->json(true);
    }

    public function delete(Website $website)
    {
        $website->delete();
        return response()->json('Website deleted!');
    }

    public function changePhoto(Request $request, Website $website)
    {
        $website->logo = $request->logo;
        $website->save();
        return response()->json('Photo saved!');
    }

    protected function getWebsite($request)
    {
        return [
            'name' => $request->name,
            'logo' => $request->logo ? $this->getImage($request->logo) : null,
            'url' => $request->url,
            'host' => $request->host,
            'database' => $request->database,
            'username' => $request->username,
            'password' => $request->password,
            'prefix' => $request->prefix,
        ];
    }

    protected function getImage($image)
    {
        $data = get_base64_string($image);
        if ($data) {
            $image = Image::make($data);
            $filename = '/uploads/img/' . str_random(16) . '.jpg';
            $image->fit(500, 500)->save(public_path($filename));
            return $filename;
        }
        return null;
    }

    protected function validator()
    {
        return [
            'name' => 'required',
            'url' => 'required',
            'host' => 'required',
            'database' => 'required',
            'username' => 'required',
        ];
    }
}
