<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;

use App\File;

use DB;

use Storage;

use Session;

class MediaController extends Controller
{
	
	public function index()
	{	
		
		$directory = 'sops';
		
		$files = $this->getNewFiles($directory);
		
		return view('media.index')->with('files',$files);	
	
	}
	
	
	public function upload(Request $request)
	{
		$file = $request->file('file');
		$currentDirID = $request->curDirID;
		
		$currentDirObj = file::find($currentDirID);
		$currentDir = $currentDirObj->path;
		
		$uniqueFileName = $file->getClientOriginalName();
		 
		if (Storage::exists($currentDir . '/' . $uniqueFileName)){
			return response()->json(['result'=>'fail', 'message'=>'There is already a file with the same name in this folder']);
		
		} else {
			
			$path = $file->storeAs($currentDir, $uniqueFileName);
		
		
			//save file info to db
			$file = new File;
			$file->type = 'file';
			$file->name = $uniqueFileName;
			$file->path = $path;
			$file->containingfilepath = $currentDir;
			$file->save();
			
			//take the new dir and files in current dir
			$newContents = $this->getNewFiles($currentDir);
			
			return response()->json(['result'=>'success','folder'=>$currentDir,'files'=>$newContents]);
		}
	 
		
	}
	
	//Get files - non Ajax
	public function getNewFiles($dir)
	{
		$files = [];
		$storageFiles = Storage::files($dir);
		$storageFolders = Storage::directories($dir);
		

		
		foreach ($storageFiles as $file) {
			
			//get the id from db
			$id = file::where('path', $file)->get(['id']);

					$files[] = [
						'name'     => strpos($file, '/') > 1 ? str_replace('/', '', strrchr($file, '/')) : $file,
						'type'     => 'file',
						'path'     => $file,
						'id'       => $id[0]['id']
					];
				
		}
			
		 foreach ($storageFolders as $folder) {
			
			//get the id from db
			$id = file::where('path', $folder)->get(['id']);	
			

				 $files[] = [
					'name'     => strpos($folder, '/') > 1 ? str_replace('/', '', strrchr($folder, '/')) : $folder,
					'type'     => 'folder',
					'path'     => $folder,	
					'id'       => $id[0]['id']
				];
			 
		} 
		 
		
		
		return $files;
	}
	
	
	//Get files by DirID - With Ajax
	public function getFiles(Request $request){
	
		$folderID  = $request->id;
		
		$dir = file::find($folderID);
		//$dirName  = substr(strrchr($dir, '/'), 1);
		
		$files = $this->getNewFiles($dir->path);
		
		return response()->json(['curDirName'=>$dir->name,'curDirPath'=>$dir->path,'curDirID'=>$folderID,'files'=>$files]);
	
	}
	
	
	//Get files by Dir Path - With Ajax
	public function getFilesByDirPath(Request $request)
	{
		$path = $request->path;
		
		$dir = file::where('path', $path)
                ->where('type', 'folder')
                ->get();

		$curDirName = $dir[0]->name;
		$curDirPath = $dir[0]->path;
		$curDirID = $dir[0]->id;
		
		$files = $this->getNewFiles($path);
		
		return response()->json(['curDirName'=>$curDirName,'curDirPath'=>$path ,'curDirID'=>$curDirID,'files'=>$files]);
		
	}
	
	
	public function findDirID(Request $request)
	{
		
		$dirPath  = $request->path;
		
		$dirID =  file::where('path', $dirPath)->get();
		
		return $dirID[0]->id;
		
	}
	
	
	public function destroy(Request $request){
		
		$id =  $request->id;
		$curDirID = $request->curDirID;
		$currentFolder = file::find($curDirID);
		$current = $currentFolder->path;
	
		$itemToDelete = file::where('id', $id)->get();
		
		//delete file or folder
		
		if($itemToDelete[0]->type=='file'){
			Storage::delete($itemToDelete[0]->path);
			$deletedFileFromDb = file::where('id', $id)->delete();
		} else{
			Storage::deleteDirectory($itemToDelete[0]->path);
			$deletedFilesInFolder = file::where('containingfilepath', $itemToDelete[0]->path)->delete();
			$deletedFilesInFolder = file::where('id', $id)->delete();
		}
		
		$files = $this->getNewFiles($current);

		return response()->json(['files'=>$files]);
		//return response()->json(['message'=>$current]);
	}
	
	public function edit(Request $request){
		
		$id =  $request->id;
		$newName =  $request->folderName;
		$item = file::find($id);
		$oldPath = $item->path;
		$newPath = $item->containingfilepath . '/' . $newName;
		
		if($item->type=='file'){
			
			
		}else{
		  
		  $all=file::where('containingfilepath', 'LIKE', $oldPath . '%')->get();
		  Storage::move($oldPath, $newPath);
	
		foreach($all as $row){
			//$newPath     = str_replace($oldPath . '/', $newPath . '/',$row->path);
			//$newContPath = str_replace($oldPath , $newPath ,$row->containingfilepath);
			
			$inside = '';
			
			$inside = file::find($row->id);
			
			$oldPathInside = $inside->path;
			$newPathInside = str_replace($oldPath . '/', $newPath . '/',$row->path);
			
			$inside->path = $newPathInside;
			$inside->containingfilepath = $newPath;
			$inside->save();
			
			Storage::move($oldPathInside, $newPathInside);
			
		}
			
			
			$item->name = $newName;
			$item->path = $newPath;
			
			$item->save();
	
		}
		
		return response()->json(['files'=>count($inside)]);
		
	}
	
	public function createDir(Request $request){
		

		$name = $request->folderName;
		$curDirID = $request->curDirID;
		
		
		if (($curDirID =='sops')||($curDirID==0)){
			
			//sops is the folder
			$current = 'sops';
			$currentid = 0;
			$path = 'sops/' . $name;
			
			
			
			if (!Storage::disk('local')->has($path)){
				//insert to db	
				$file = new File;
				$file->type = 'folder';
				$file->name = $name;
				$file->path = $path;
				$file->containingfilepath = 'sops';
				$file->save();
				
				//create actual file
			    Storage::makeDirectory($path);
				
			} else {
				return response()->json(['result'=>'fail', 'message'=>'There is already a folder with the same name']);
			}	
			
		} else {
			$currentFolder = file::find($curDirID);
			$current = $currentFolder->path;
			$currentid = $currentFolder->id;
			$path = $currentFolder->path . '/' . $name;
			
			if (!Storage::disk('local')->has($path))
			{
				//insert to db	
				$file = new File;
				$file->type = 'folder';
				$file->name = $name;
				$file->path = $path;
				$file->containingfilepath = $currentFolder->path;
				$file->save();
				
				//create actual file
				Storage::makeDirectory($path);
			
			} else {
				return response()->json(['result'=>'fail', 'message'=>'There is already a folder with the same name']);
			}
		}
			
			
		$files = $this->getNewFiles($current);
		
		return response()->json(['result'=>'success','curDirName'=>$name,'curDirPath'=>$path,'curDirID'=>$currentid,'files'=>$files]);
	
	
	}

}
