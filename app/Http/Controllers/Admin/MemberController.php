<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Member;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $members = Member::all();
        return view('admin.members.index', compact('members'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.members.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'nit' => 'required|string|unique:members,nit|max:255',
            'kelas' => 'required|string|max:255',
            'jurusan' => 'required|string|max:255',
            'username' => 'required|string|unique:members,username|max:255',
        ]);

        Member::create($request->all());

        return redirect()->route('admin.members.index')->with('success', 'Anggota berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Member $member)
    {
        return view('admin.members.show', compact('member'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Member $member)
    {
        return view('admin.members.edit', compact('member'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Member $member)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'nit' => 'required|string|max:255|unique:members,nit,'.$member->id,
            'kelas' => 'required|string|max:255',
            'jurusan' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:members,username,'.$member->id,
        ]);

        $member->update($request->all());

        return redirect()->route('admin.members.index')->with('success', 'Anggota berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Member $member)
    {
        $member->delete();

        return redirect()->route('admin.members.index')->with('success', 'Anggota berhasil dihapus.');
    }
    
    /**
     * Import members from CSV
     */
    public function importCsv(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:csv,txt|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $file = $request->file('file');
        $path = $file->store('temp');
        $filePath = storage_path('app/' . $path);

        $data = array_map('str_getcsv', file($filePath));
        $header = array_shift($data);

        foreach ($data as $row) {
            if (count($row) >= 5) { // Ensure we have enough columns (nama, nit, kelas, jurusan, username)
                Member::updateOrCreate(
                    ['username' => $row[4]], // Assuming username is in the fifth column
                    [
                        'nama' => $row[0],
                        'nit' => $row[1],
                        'kelas' => $row[2],
                        'jurusan' => $row[3],
                        'username' => $row[4]
                    ]
                );
            }
        }

        Storage::delete($path);

        return redirect()->route('admin.members.index')->with('success', 'Data anggota berhasil diimpor dari CSV.');
    }
}