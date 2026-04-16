using System.Diagnostics;

string? FindSetupBatPath()
{
    var candidates = new[]
    {
        Environment.CurrentDirectory,
        AppContext.BaseDirectory,
    };

    foreach (var start in candidates)
    {
        var dir = new DirectoryInfo(start);

        while (dir is not null)
        {
            var potential = Path.Combine(dir.FullName, "setup.bat");

            if (File.Exists(potential))
            {
                return potential;
            }

            dir = dir.Parent;
        }
    }

    return null;
}

var batchPath = FindSetupBatPath();

if (batchPath is null)
{
    Console.Error.WriteLine("setup.bat not found from the current folder or executable folder.");
    return 1;
}

var repoRoot = Path.GetDirectoryName(batchPath)!;

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