using System.Diagnostics;

var repoRoot = Path.GetFullPath(Path.Combine(AppContext.BaseDirectory, "..", "..", "..", ".."));
var batchPath = Path.Combine(repoRoot, "setup.bat");

if (!File.Exists(batchPath))
{
    Console.Error.WriteLine($"setup.bat not found at {batchPath}");
    return 1;
}

var startInfo = new ProcessStartInfo
{
    FileName = "cmd.exe",
    Arguments = $"/c \"{batchPath}\"",
    WorkingDirectory = repoRoot,
    UseShellExecute = false,
};

using var process = Process.Start(startInfo);

if (process is null)
{
    Console.Error.WriteLine("Failed to start setup.bat");
    return 1;
}

process.WaitForExit();
return process.ExitCode;