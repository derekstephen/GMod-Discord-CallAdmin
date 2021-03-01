function ulx.calladmin( calling_ply, target_ply, reason)
	someOneIsBadBoiii(calling_ply, target_ply, reason)
	
	ulx.fancyLogAdmin( calling_ply, "#A called an admin!" )
end
local calladmin = ulx.command( "Call Admin", "ulx calladmin", ulx.calladmin, "!calladmin" )
calladmin:addParam{ type=ULib.cmds.PlayerArg }
calladmin:addParam{ type=ULib.cmds.StringArg, hint="text" }
calladmin:defaultAccess( ULib.ACCESS_ALL )
calladmin:help( "Calls an admin in our discord server to come help!" )


function ulx.claimserver(calling_ply)
	someOneIsGoodBoiii(calling_ply)
	
	ulx.fancyLogAdmin( calling_ply, "#A claimed the server!" )
end
local claimserver = ulx.command( "Call Admin", "ulx claim", ulx.claimserver, "!claim" )
claimserver:defaultAccess( ULib.ACCESS_ADMIN )
claimserver:help( "Claim server in Need an Admin." )
